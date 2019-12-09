import RecipeList from './recipe-list.jsx';
import CacheRecipe from './cache.js';
import DisableEmojisRecipe from './disable-emojis.js';
import DisableWebFonts from './disable-web-fonts.js';
import ReduceJPEGQuality from './reduce-jpeg-quality.js';
import PluginDisableEmojisRecipe from './plugin-disable-emojis.js';
import { Store, withSelect, withDispatch, retrieveRecipeStates, saveRecipeStates } from '../store';
import WPSuperCacheRecipe from './wp-super-cache.js';
import WebP from './web-p';
import WebPExpress from './web-p-express';

var recipes = {};
[
  new CacheRecipe(),
  new DisableEmojisRecipe(),
  new DisableWebFonts(),
  new PluginDisableEmojisRecipe(),
  new ReduceJPEGQuality(),
  new WPSuperCacheRecipe(),
  new WebP(),
  new WebPExpress(),
].forEach( instance => recipes[instance.id] = instance );

var Recipes = withSelect( ( select, ownProps ) => {
  const { hasError, getRecipes, getStepToggled, isLoading } = select( 'greenerwp' );
  return {
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

retrieveRecipeStates();

module.exports = Recipes;
