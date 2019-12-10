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
	requestAnalysis() {
		return {
			type: 'FETCH_ANALYSIS',
		};
	},
	receiveAnalysis( state ) {
		return {
			type: 'FETCH_ANALYSIS',
			status: 'success',
			response: state,
		};
	},
	receiveAnalysisError( state ) {
		return {
			type: 'FETCH_ANALYSIS',
			status: 'error',
		};
	},
	requestRecipeStates() {
		return {
			type: 'FETCH_RECIPESTATES',
		};
	},
	receiveRecipeStates( state ) {
		return {
			type: 'FETCH_RECIPESTATES',
			status: 'success',
			response: state,
		};
	},
	receiveRecipeStatesError( state ) {
		return {
			type: 'FETCH_RECIPESTATES',
			status: 'error',
		};
	},
	savingSettings( saving=false ) {
		return {
			type: 'SAVING_SETTINGS',
			saving: saving,
		};
	},
	updateSetting( key, value=null ) {
		return {
			type: 'UPDATE_SETTING',
			key,
			value,
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

// Reducer for analysis.
function analysis( state = { }, action ) {
	switch ( action.type ) {
	case 'FETCH_ANALYSIS':
		switch ( action.status ) {
		case 'success':
			return action.response;
		}
	}
	return state;
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
	case 'FETCH_RECIPESTATES':
		switch ( action.status ) {
		case 'success':
			return action.response;
		}
	}
	return state;
};

// Reducer for setting update.
function settings( state = { weather_location: 'foo' }, action ) {
	switch ( action.type ) {
	case 'UPDATE_SETTING':
		return {
			...state,
			[action.key]: action.value,
		};
	case 'FETCH_SETTINGS':
		switch ( action.status ) {
		case 'success':
			return action.response;
		}
	}
	return state;
};

// Reducer for analysis fetching.
function fetchAnalysis( state = { isLoading: false }, action ) {
	switch ( action.type ) {
	case 'FETCH_ANALYSIS':
		switch ( action.status ) {
		case undefined:
			return {
				...state,
				isLoading: true,
			};
		case 'success':
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

// Reducer for recipeStates fetching.
function fetchRecipeStates( state = { isLoading: false }, action ) {
	switch ( action.type ) {
	case 'FETCH_RECIPESTATES':
		switch ( action.status ) {
		case undefined:
			return {
				...state,
				isLoading: true,
			};
		case 'success':
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

// Reducer for settings fetching.
function fetchSettings( state = { isLoading: false }, action ) {
	switch ( action.type ) {
	case 'SAVING_SETTINGS':
		console.log( 'saving?', action.saving );
		return {
			...state,
			isSaving: action.saving,
		};
	case 'FETCH_SETTINGS':
		switch ( action.status ) {
		case undefined:
			return {
				...state,
				isLoading: true,
			};
		case 'success':
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

const Store = registerStore( 'greenerwp', {
	reducer: combineReducers( {
		fetchAnalysis,
		fetchRecipeStates,
		analysis,
		stepToggled,
		settings,
		fetchSettings,
	} ),
	actions,

	selectors: {
		getAnalysis( state ) {
			return state.analysis;
		},
		getRecipes( state ) {
			return state.recipes;
		},
		getSettings( state ) {
			return state.settings;
		},
		getStepToggled( state ) {
			return state.stepToggled || {};
		},
		isSaving( state ) {
			return state.fetchSettings && state.fetchSettings.isSaving;
		},
		isLoading( state ) {
			return state.fetchRecipeStates && state.fetchRecipeStates.isLoading
				|| state.fetchAnalysis && state.fetchAnalysis.isLoading
				|| state.fetchSettings && state.fetchSettings.isLoading;
		},
		hasError( state ) {
			return state.fetchRecipeStates && state.fetchRecipeStates.error
				|| state.fetchAnalysis && state.fetchAnalysis.error
				|| state.fetchSettings && state.fetchSettings.error;
		},
	},
} );

async function retrieveAnalysis() {
	Store.dispatch( actions.requestAnalysis() );
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
	};
	var response = await fetch( wpApiSettings.root + 'greenerwp/v1/analysis', opts );
	var json = await response.json();
	if ( json ) {
		Store.dispatch( actions.receiveAnalysis( json ) );
	} else {
		Store.dispatch( actions.receiveAnalysisError() );
	}
}

async function retrieveRecipeStates() {
	Store.dispatch( actions.requestRecipeStates() );
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
	};
	var response = await fetch( wpApiSettings.root + 'greenerwp/v1/recipes', opts );
	var json = await response.json();
	if ( json ) {
		Store.dispatch( actions.receiveRecipeStates( json ) );
	} else {
		Store.dispatch( actions.receiveRecipeStatesError() );
	}
}

async function saveRecipeStates() {
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		method: 'POST',
		body: JSON.stringify( Store.getState().stepToggled ),
	};
	fetch( wpApiSettings.root + 'greenerwp/v1/recipes', opts );
}

async function retrieveSettings() {
	Store.dispatch( actions.requestSettings() );
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
	};
	var response = await fetch( wpApiSettings.root + 'greenerwp/v1/settings', opts );
	var json = await response.json();
	if ( json ) {
		Store.dispatch( actions.receiveSettings( json ) );
	} else {
		Store.dispatch( actions.receiveSettingsError() );
	}
}

async function saveSettings() {
	Store.dispatch( actions.savingSettings( true ) );
	const opts = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		method: 'POST',
		body: JSON.stringify( Store.getState().settings ),
	};
	var response = await fetch( wpApiSettings.root + 'greenerwp/v1/settings', opts );
	Store.dispatch( actions.savingSettings( false ) );
}

export {
	Store as default, withSelect, withDispatch,
	saveRecipeStates,
	retrieveAnalysis,
	retrieveRecipeStates,
	saveSettings,
	retrieveSettings,
};