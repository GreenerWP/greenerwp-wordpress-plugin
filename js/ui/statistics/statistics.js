import StatisticsTable from './statistics-table.jsx';
import { Store, withSelect, withDispatch, clearStatistics, retrieveStatistics } from '../store';

var applyWithSelect = withSelect( ( select, ownProps ) => {
  const { hasError, getStatistics, isLoading, isSaving } = select( 'greenerwp' );
  return {
		hasError: hasError(),
    isLoading: isLoading(),
    isSaving: isSaving(),
    statistics: getStatistics(),
  };
} );

var applyWithDispatch = withDispatch( ( dispatch, ownProps ) => {
	return {
		clearStatistics: clearStatistics,
	};
} );

retrieveStatistics();

module.exports = wp.compose.compose(
	applyWithDispatch,
	applyWithSelect,
)( StatisticsTable );