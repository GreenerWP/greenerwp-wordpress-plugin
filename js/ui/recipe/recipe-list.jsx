import Recipe from './recipe.jsx';

const { __, _x, _n, _nx } = wp.i18n;

const RecipeList = ( props ) => (
  <div>
    <p>
      {__( 'Optimize your site by following these step by step instructions. Click the checkboxes to mark items as done.', 'ltwp' )}
    </p>
    { Object.keys( props.recipes ).map( name => {
        let recipe = props.recipes[name];
        if ( recipe.showOnlyAsDependency ) {
          return null;
        }
        return <Recipe key={name} {...props} done={true} recipe={recipe} />; })
    }
  </div>
);

export default RecipeList;
