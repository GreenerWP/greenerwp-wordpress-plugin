import Recipe from './recipe.jsx';

const { __, _x, _n, _nx } = wp.i18n;

const RecipeList = ( props ) => (
  <div>
    <p>
      {__( 'Optimise your site by following these step by step instructions. Click the checkboxes to mark items as done. Some items will be checked for automatically.', 'greenerwp' )}
			<br/>
      {__( 'The recipes are ordered by their average impact. You might want to optimise your site from top to bottom.', 'greenerwp' )}
    </p>
    { props.isLoading && (
    <p>
      {__( 'Loading recipes...', 'greenerwp' )}
    </p>
    ) }
		{ props.hasError && (
			<p>
				{__( 'Could not load recipes.', 'greenerwp' )}
			</p>
		) }
    { ! props.isLoading && ! props.hasError && Object.keys( props.recipes ).map( name => {
        let recipe = props.recipes[name];
				var isVisible = recipe.visible;
				if ( isVisible instanceof Function ) {
					isVisible = isVisible( props.analysis );
				}
        if ( ! isVisible ) {
          return null;
        }
        if ( recipe.showOnlyAsDependency ) {
          return null;
        }
        return <Recipe key={name} {...props} done={true} recipe={recipe} />; })
    }
  </div>
);

export default RecipeList;
