const { __, _x, _n, _nx } = wp.i18n;

import Step from './step.jsx';
import MarkdownParser from '../../tools/markdown-parser.js';

class Recipe extends wp.element.Component {
  constructor( props ) {
    super( props );
    this.state = {
      isEvaluating: true,
      wasOpenBefore: false,
    };
    this.onTitleClick = this.onTitleClick.bind( this );
    this.onToggleStep = this.onToggleStep.bind( this );
  };

  onTitleClick( event ) {
    if ( ! this.state.wasOpenBefore && this.props.recipe.evaluate ) {
      this.props.recipe.evaluate().then( results => {
        this.setState( {
          isEvaluating: false,
          results: results,
        } );
      } );
    }
    this.setState( state => { return {
      open: ! state.open,
      wasOpenBefore: false,
    }; } );
  }

  onToggleStep( recipe, step ) {
  };

  allStepsDone( recipeId ) {
    var allStepsDone = true;
    if ( this.props.recipes[recipeId].steps ) {
      this.props.recipes[recipeId].steps.forEach( ( step ) => {
        var stepDone;
        if ( step.type === 'recipe' ) {
          stepDone = this.allStepsDone( step.args.recipe );
        } else {
          stepDone = this.props.stepToggled[recipeId + '.' + step.id];
        }
        if ( ! stepDone ) {
          allStepsDone = false;
        }
      } );
    }
    return allStepsDone;
  };

  parseMarkDown(text) {
    var parser = new MarkdownParser();
    return <span dangerouslySetInnerHTML={ { __html: parser.parse( text ) } }/>;
  }

  render() {
    var status;
    const recipe = this.props.recipe;
    if ( this.state.isEvaluating ) {
      status = __( 'Evaluating', 'lowtechwp' ) + '…';
    } else {
      const results = this.state.results;
      switch ( results.status ) {
        case 'failed':
          status = recipe.failedMessage;
          break;
        case 'passed':
          status = recipe.passedMessage;
          break;
        case 'error':
        default:
          status = recipe.errorMessage;
      }
    };

    const allStepsDone = this.allStepsDone( recipe.id );
    return (
      <div className={"ltwp-recipe "
                    + ( allStepsDone ? 'ltwp-recipe--done ' : '' )
                    + ( this.state.open ? 'ltwp-recipe--open ' : '' )}>
        <button className="ltwp-recipe__title" onClick={this.onTitleClick}>
          {recipe.name}
          <span className="ltwp-recipe__status">
            { allStepsDone ? __( 'Done', 'ltwp' ) : __( 'Todo', 'ltwp' )}</span>
        </button>
        <div className="ltwp-recipe__content">
          <p className="ltwp-recipe__description">{ this.parseMarkDown( recipe.description ) }</p>
          { recipe.evaluate && <p className="">{__( 'Status', 'lowtechwp' )}: {status}</p> }
          <ul>
            { recipe.steps.map( step => { step.done = false; return <Step key={step.id} {...this.props} step={step} />; } ) }
          </ul>
        </div>
      </div>
    );
	};
}

export default Recipe;
