import CacheRecipe from './cache.js';
import Recipe from './recipe.jsx';

const { __, _x, _n, _nx } = wp.i18n;

class Recipes extends wp.element.Component {
  constructor( props ) {
    super( props );
  };

  render() {
		return (
      <div>
        <p>
          {__( 'Optimize your site by following these step by step instructions.', 'ltwp' )}
        </p>
        <Recipe done={true} check={new CacheRecipe()}/>
      </div>
		);
	};
}

module.exports = Recipes;
