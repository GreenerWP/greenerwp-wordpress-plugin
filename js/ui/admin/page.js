if ( document.getElementById( 'lowtechwp-recipes' ) ) {
	import( '../recipe/recipes' ).then(
		(Recipes) => {
			wp.element.render( <div className="wrap"><Recipes/></div>, document.getElementById( 'lowtechwp-recipes' ) );
		} );
}

if ( document.getElementById( 'lowtechwp-settings' ) ) {
	import( '../settings/settings' ).then(
		(SettingsTabs) => {
			wp.element.render( <div className="wrap"><SettingsTabs/></div>, document.getElementById( 'lowtechwp-settings' ) );
		} );
}
