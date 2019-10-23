import SettingsTabs from './settings-tabs.jsx';
// import { Store, withSelect, withDispatch } from './store';

// var settings = {};
// [
//   new CacheRecipe(),
//   new DisableEmojisRecipe(),
//   new PluginDisableEmojisRecipe(),
//   new WPSuperCacheRecipe(),
//   new WebP(),
//   new WebPExpress(),
// ].forEach( instance => settings[instance.id] = instance );

// var Settings = withSelect( ( select, ownProps ) => {
//   const { hasError, getSettings, getStepToggled, isLoading } = select( 'ltwp-settings' );
//   return {
//     isLoading: isLoading(),
//     stepToggled: getStepToggled(),
//     hasError: hasError(),
//     settings: settings,
//   };
// } )( RecipeList );

// Settings = withDispatch( ( dispatch, ownProps ) => {
//   const { toggleStep } = dispatch( 'ltwp-settings' );
//   return {
//     onToggleStep( recipe, step ) {
//       toggleStep( recipe, step );
//     },
//   };
// } )( Settings );

module.exports = SettingsTabs;
