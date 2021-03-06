import RecipeList from './recipe-list.jsx';
import CacheRecipe from './cache.js';
import DisableEmojisRecipe from './disable-emojis.js';
import DisableWebFonts from './disable-web-fonts.js';
import GreenHosting from './green-hosting.js';
import ReduceJPEGQuality from './reduce-jpeg-quality.js';
import PluginDisableEmojisRecipe from './plugin-disable-emojis.js';
import { Store, withSelect, withDispatch, retrieveAnalysis, retrieveRecipeStates, saveRecipeStates } from '../store';
import WPSuperCacheRecipe from './wp-super-cache.js';
import WebP from './web-p';
import WebPExpress from './web-p-express';
import WPCF7 from './plugins/wpcf7.js';

var recipes = {};
[
  new GreenHosting(),
  new CacheRecipe(),
  new WebP(),
  new ReduceJPEGQuality(),
  new DisableWebFonts(),
  new WPCF7(),
  new DisableEmojisRecipe(),

	// Hidden recipes
  new WPSuperCacheRecipe(),
  new PluginDisableEmojisRecipe(),
  new WebPExpress(),
].forEach( instance => recipes[instance.id] = instance );

var Recipes = withSelect( ( select, ownProps ) => {
  const { hasError, getAnalysis, getRecipes, getStepToggled, isLoading } = select( 'greenerwp' );
  return {
    analysis: getAnalysis(),
    isLoading: isLoading(),
    stepToggled: getStepToggled(),
    hasError: hasError(),
    recipes: recipes,
  };
} )( RecipeList );

Recipes = withDispatch( ( dispatch, ownProps ) => {
  const { toggleStep } = dispatch( 'greenerwp' );
  return {
    onToggleStep( recipe, step ) {
      toggleStep( recipe, step );
			saveRecipeStates();
    },
  };
} )( Recipes );

retrieveAnalysis();
retrieveRecipeStates();

module.exports = Recipes;
