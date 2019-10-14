const { applyMiddleware, withSelect, withDispatch, registerStore, combineReducers } = wp.data;
const createMiddleware = wp.reduxRoutine;

const actions = {
	toggleStep( recipe, step=null ) {
		return {
			type: 'TOGGLE_STEP',
			recipe,
			step,
		};
	},
	requestSettings() {
		return {
			type: 'FETCH_SETTINGS',
		};
	},
	receiveSettings( state ) {
		return {
			type: 'FETCH_SETTINGS',
			status: 'success',
			response: state,
		};
	},
	receiveSettingsError( state ) {
		return {
			type: 'FETCH_SETTINGS',
			status: 'error',
		};
	},
};


// Reducer for step toggling.
function stepToggled( state = {}, action ) {
	const key = action.step ? action.recipe + '.' + action.step : action.recipe;
	switch ( action.type ) {
	case 'TOGGLE_STEP':
		return {
			...state,
			[key]: ! state[key],
		};
	case 'FETCH_SETTINGS':
		switch ( action.status ) {
		case 'success':
			return action.response;
		}
	}
	return state;
};


// Reducer for settings fetching.
function fetchSettings( state = { isLoading: true }, action ) {
	switch ( action.type ) {
	case 'FETCH_SETTINGS':
		switch ( action.status ) {
		case undefined:
			return {
				...state,
				isLoading: true,
			};
		case 'success':
			return action.response.stepToggled;
			return {
				...state,
				isLoading: false,
			};
		case 'error':
			return {
				...state,
				error: true,
				isLoading: false,
			};
		}
	}
	return state;
};

const Store = registerStore( 'ltwp-recipes', {
	reducer: combineReducers( {
		fetchSettings,
		stepToggled,
	} ),
	actions,

	selectors: {
		getRecipes( state ) {
			return state.recipes;
		},
		getStepToggled( state ) {
			return state.stepToggled || {};
		},
		isLoading( state ) {
			return state.fetchSettings && state.fetchSettings.isLoading;
		},
		hasError( state ) {
			return state.fetchSettings && state.fetchSettings.error;
		},
	},
} );

async function retrieveSettings() {
	Store.dispatch( actions.requestSettings() );
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
	};
	var response = await fetch( wpApiSettings.root + 'ltwp/v1/recipes', opts );
	var json = await response.json();
	if ( json ) {
		Store.dispatch( actions.receiveSettings( json ) );
	} else {
		Store.dispatch( actions.receiveSettingsError() );
	}
}

retrieveSettings();

async function saveSettings() {
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		method: 'POST',
		body: JSON.stringify( store.getState().stepToggled ),
	};
	fetch( wpApiSettings.root + 'ltwp/v1/recipes', opts );
}

window.saveSettings = saveSettings;

export { Store as default, withSelect, withDispatch };