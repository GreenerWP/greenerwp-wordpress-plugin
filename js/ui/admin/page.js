if ( document.getElementById( 'greenerwp-recipes' ) ) {
	import( '../recipe/recipes' ).then(
		(Recipes) => {
			wp.element.render( <div className="wrap"><Recipes/></div>, document.getElementById( 'greenerwp-recipes' ) );
		} );
}

if ( document.getElementById( 'greenerwp-settings' ) ) {
	import( '../settings/settings' ).then(
		(SettingsTabs) => {
			wp.element.render( <div className="wrap"><SettingsTabs/></div>, document.getElementById( 'greenerwp-settings' ) );
		} );
}
