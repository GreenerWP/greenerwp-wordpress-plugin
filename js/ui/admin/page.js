import( '../recipe/recipes' ).then(
  (Recipes) => {
    wp.element.render( <div className="wrap"><Recipes/></div>, document.getElementById( 'lowtechwp-recipes' ) );
  } );
