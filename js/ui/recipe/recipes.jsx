import RecipeList from './recipe-list.jsx';
import CacheRecipe from './cache.js';
import DisableEmojisRecipe from './disable-emojis.js';
import PluginDisableEmojisRecipe from './plugin-disable-emojis.js';
import WPSuperCacheRecipe from './wp-super-cache.js';
import WebP from './web-p';
import WebPExpress from './web-p-express';

const { withSelect, withDispatch, registerStore } = wp.data;

const DEFAULT_STATE = {
  stepToggled: {},
};

var recipes = {};
[
  new CacheRecipe(),
  new DisableEmojisRecipe(),
  new PluginDisableEmojisRecipe(),
  new WPSuperCacheRecipe(),
  new WebP(),
  new WebPExpress(),
].forEach( instance => recipes[instance.id] = instance );

const actions = {
	toggleStep( recipe, step=null ) {
		return {
			type: 'TOGGLE_STEP',
			recipe,
      step,
		};
	},
};

const store = registerStore( 'ltwp-recipes', {
	reducer( state = DEFAULT_STATE, action ) {
    const key = action.step ? action.recipe + '.' + action.step : action.recipe;
    switch ( action.type ) {
      case 'TOGGLE_STEP':
        return {
          ...state,
          stepToggled: {
            ...state.stepToggled,
            [key]: ! state.stepToggled[key],
          }
        };
    }
    return state;
  },

  actions,

	selectors: {
    getRecipes( state ) {
      return state.recipes;
    },
    getStepToggled( state ) {
      return state.stepToggled;
    },
  },
} );


var Recipes = withSelect( ( select, ownProps ) => {
  const { getRecipes, getStepToggled } = select( 'ltwp-recipes' );
  return {
    stepToggled: getStepToggled(),
    recipes: recipes,
  };
} )( RecipeList );

Recipes = withDispatch( ( dispatch, ownProps ) => {
  const { toggleStep } = dispatch( 'ltwp-recipes' );
  return {
    onToggleStep( recipe, step ) {
      toggleStep( recipe, step );
    },
  };
} )( Recipes );

module.exports = Recipes;
