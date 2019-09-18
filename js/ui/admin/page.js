import( './suggestions' ).then(
  (Suggestions) => {
    wp.element.render( <Suggestions/>, document.getElementById( 'lowtechwp-suggestions' ) );
  } );
