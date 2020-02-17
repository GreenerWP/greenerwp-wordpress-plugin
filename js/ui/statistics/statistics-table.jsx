import {
	usePagination,
	useSortBy,
  useTable
} from 'react-table'

const { Button } = wp.components;

import React from 'react';

const { __, _x, _n, _nx } = wp.i18n;

const StatisticsTable = ( props ) => {
	var entries = [];

	const columns = React.useMemo( () => [
		{
			Header: __( 'Path', 'greenerwp' ),
			Cell: ( { cell: {value}, row: row } ) => (
				<>
				{String(value)}
				<div class="row-actions">
					<a target="_blank" href={"https://scan.greenerwp.net/?url=" + encodeURIComponent( row.original.url ) }>{ __( 'Scan page', 'greenerwp' ) }</a>
				</div>
				</>
			),
			accessor: 'path',
		},
		{
			Header: __( 'Post', 'greenerwp' ),
			Cell: ( { cell: {value}, row: row } ) => (
				<>
					{ value &&
						<a href={ row.original.permalink }>
							{String(value)}
						</a>
					}
				</>
			),
			accessor: 'title',
		},
		{
			Header: __( 'Transferred per View', 'greenerwp' ),
			Cell: ( { cell: {value}, row: row } ) => (
				<>
					Ø {String( Math.round( value / 1000 ) / 1000 )} MB<br/>
					<small>
						({String( Math.round( row.original.minTransferred / 1000 ) / 1000 )} -
						{String( Math.round( row.original.maxTransferred / 1000 ) / 1000 )} MB)
					</small>
				</>
			),
			accessor: 'avgTransferred',
			sortType: 'basic',
			sortDescFirst: true,
		},
		{
			Header: __( 'Views', 'greenerwp' ),
			Cell: ( { cell: {value} } ) => (
				<>{String( Math.round( value * 100 ) )}%</>
			),
			accessor: 'views',
			sortType: 'basic',
			sortDescFirst: true,
		},
		{
			Header: __( 'Total', 'greenerwp' ),
			Cell: ( { cell: {value} } ) => (
				<>Ø {String( Math.round( value * 100 ) )}%</>
			),
			accessor: 'totalTransferred',
			sortType: 'basic',
			sortDescFirst: true,
		},
	], [] );

	const {
		getTableProps,
		getTableBodyProps,
		headerGroups,
		rows,
		page,
		prepareRow,
    canPreviousPage,
    canNextPage,
    pageOptions,
    pageCount,
    gotoPage,
    nextPage,
    previousPage,
    setPageSize,
    state: { pageIndex, pageSize },
  } = useTable({
    columns,
    data: props.statistics.pages,
		disableSortRemove: true,
		initialState: {
			pageIndex: 0,
			pageSize: 10,
			sortBy: [
				{
					id: 'totalTransferred',
					desc: true,
				},
			],
		},
  },
							 useSortBy,
							 usePagination
	);

	var table = (
		<table {...getTableProps()} class="wp-list-table widefat fixed striped ">
      <thead>
        {headerGroups.map(headerGroup => (
          <tr {...headerGroup.getHeaderGroupProps()}>
            {headerGroup.headers.map(column => (
							<th {...column.getHeaderProps(column.getSortByToggleProps())}>
								{column.render('Header')}
								<span>
                  {column.isSorted
                  ? column.isSortedDesc
                  ? ' 🔽'
                  : ' 🔼'
                  : ''}
                </span>
							</th>
            ))}
          </tr>
        ))}
      </thead>
			<tbody {...getTableBodyProps()}>
				{page.map(
					(row, i) => {
						prepareRow(row);
						return (
							<tr {...row.getRowProps()}>
								{row.cells.map(cell => {
									return <td {...cell.getCellProps()}>{cell.render('Cell')}</td>
								})}
							</tr>
						)}
				)}
			</tbody>
		</table>
	);
	var pagination = (
		<div class="tablenav">
			<div className="actions alignleft">
				<Button isPrimary disabled={props.isLoading} isBusy={props.isLoading} onClick={props.clearStatistics}>
					{ __( 'Clear statistics', 'greenerwp' ) }
				</Button>
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num">
					{String(_n( '{0} entry in table', '{0} entries in table', rows.length, 'greenerwp' )).replace( '{0}', rows.length )}, {' '}
					{String(_n( '{0} page view recorded', '{0} page views recorded', props.statistics.views, 'greenerwp' )).replace( '{0}', props.statistics.views )}
				</span>
				<span class="pagination-links">
					<a class="first-page button" onClick={() => gotoPage(0)} disabled={!canPreviousPage}><span class="screen-reader-text">Letzte Seite</span><span aria-hidden="true">«</span></a>
					<a class="previous-page button" onClick={() => previousPage()} disabled={!canPreviousPage}><span class="screen-reader-text">{ __( 'Previous Page', 'greenerwp' ) }</span><span aria-hidden="true">‹</span></a>

					<span class="screen-reader-text">Aktuelle Seite</span>
					<span id="table-paging" class="paging-input">
						<span class="tablenav-paging-text">{pageIndex + 1} {__( 'of', 'greenerwp' )} <span class="total-pages">{pageOptions.length}</span></span>
					</span>
					<a class="next-page button" onClick={() => nextPage()} disabled={!canNextPage}><span class="screen-reader-text">Nächste Seite</span><span aria-hidden="true">›</span></a>
					<a class="last-page button" onClick={() => gotoPage(pageCount - 1)} disabled={!canNextPage}><span class="screen-reader-text">Letzte Seite</span><span aria-hidden="true">»</span></a>
				</span>
			</div>
		</div>
	);

	var view = (
		<>
		{table}
		{pagination}
		</>
	);

	return (
		<div>
			{ props.isLoading && (
					<p>
						{__( 'Loading statistics...', 'greenerwp' )}
					</p>
			) }
			{ props.hasError && (
					<p>
						{__( 'Could not load statistics.', 'greenerwp' )}
					</p>
			) }
			{ ! props.isLoading && ! props.hasError && view }
		</div>
	);
};

export default StatisticsTable;
