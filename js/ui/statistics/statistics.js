import StatisticsTable from './statistics-table.jsx';
import { Store, withSelect, withDispatch, retrieveStatistics } from '../store';

var applyWithSelect = withSelect( ( select, ownProps ) => {
  const { hasError, getStatistics, isLoading, isSaving } = select( 'greenerwp' );
  return {
		hasError: hasError(),
    isLoading: isLoading(),
    isSaving: isSaving(),
    statistics: getStatistics(),
  };
} );

retrieveStatistics();

module.exports = wp.compose.compose(
	applyWithSelect,
)( StatisticsTable );