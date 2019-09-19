const { __, _x, _n, _nx } = wp.i18n;

class Check extends wp.element.Component {
  constructor( props ) {
    super( props );
    this.state = {
      isEvaluating: true,
      wasOpenBefore: false,
    };
    this.onTitleClick = this.onTitleClick.bind( this );
  };

  onTitleClick( event ) {
    event.target.parentNode.classList.toggle( 'ltwp-recipe--open' );
    if ( ! this.state.wasOpenBefore ) {
      this.props.check.evaluate().then( results => {
        console.log(results);
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

  componentDidMount() {
  };

  render() {
    var status;
    const check = this.props.check;
    if ( this.state.isEvaluating ) {
      status = __( 'Evaluating', 'lowtechwp' ) + '…';
    } else {
      const results = this.state.results;
      switch ( results.status ) {
        case 'failed':
          status = check.failedMessage;
          break;
        case 'passed':
          status = check.passedMessage;
          break;
        case 'error':
        default:
          status = check.errorMessage;
      }
    }

    return (
      <div className={"ltwp-recipe "
                    + ( this.props.done ? 'ltwp-recipe--done' : '' )
                    + ( this.props.open ? 'ltwp-recipe--open' : '' )}>
        <button className="ltwp-recipe__title" onClick={this.onTitleClick}>
          {check.name}
          <span class="ltwp-recipe__status">Done</span>
        </button>
        <div class="ltwp-recipe__content">
          <p className="ltwp-recipe__description">{check.description}</p>
          <p className="">{__( 'Status', 'lowtechwp' )}: {status}</p>
        </div>
      </div>
    );
	};
}

export default Check;
