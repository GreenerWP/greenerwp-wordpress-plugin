import RecipeList from './recipe-list.jsx';
import CacheRecipe from './cache.js';
import DisableEmojisRecipe from './disable-emojis.js';
import PluginDisableEmojisRecipe from './plugin-disable-emojis.js';
import { Store, withSelect, withDispatch, retrieveRecipeStates, saveRecipeStates } from '../store';
import WPSuperCacheRecipe from './wp-super-cache.js';
import WebP from './web-p';
import WebPExpress from './web-p-express';

var recipes = {};
[
  new CacheRecipe(),
  new DisableEmojisRecipe(),
  new PluginDisableEmojisRecipe(),
  new WPSuperCacheRecipe(),
  new WebP(),
  new WebPExpress(),
].forEach( instance => recipes[instance.id] = instance );

var Recipes = withSelect( ( select, ownProps ) => {
  const { hasError, getRecipes, getStepToggled, isLoading } = select( 'ltwp' );
  return {
    isLoading: isLoading(),
    stepToggled: getStepToggled(),
    hasError: hasError(),
    recipes: recipes,
  };
} )( RecipeList );

Recipes = withDispatch( ( dispatch, ownProps ) => {
  const { toggleStep } = dispatch( 'ltwp' );
  return {
    onToggleStep( recipe, step ) {
      toggleStep( recipe, step );
    },
  };
} )( Recipes );

retrieveRecipeStates();

module.exports = Recipes;
