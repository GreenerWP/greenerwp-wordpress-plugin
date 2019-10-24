import SettingsTabs from './settings-tabs.jsx';
import { Store, withSelect, withDispatch, retrieveSettings, saveSettings } from '../store';

var applyWithSelect = withSelect( ( select, ownProps ) => {
  const { hasError, getSettings, isLoading, isSaving } = select( 'ltwp' );
  return {
		hasError: hasError(),
    isLoading: isLoading(),
    isSaving: isSaving(),
    settings: getSettings(),
  };
} );

var applyWithDispatch = withDispatch( ( dispatch, ownProps ) => {
	const { updateSetting } = dispatch( 'ltwp' );
  return {
		updateSetting( key, value) {
			updateSetting( key, value );
		},
		saveSettings: saveSettings,
  };
} );

retrieveSettings();

module.exports = wp.compose.compose(
	applyWithSelect,
	applyWithDispatch,
)( SettingsTabs );