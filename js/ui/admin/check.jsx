const { __, _x, _n, _nx } = wp.i18n;

class Check extends wp.element.Component {
  constructor( props ) {
    super( props );
    this.state = {
      isEvaluating: true,
    };
  };

  componentDidMount() {
    this.props.check.evaluate().then( results => {
      console.log(results);
      this.setState( {
        isEvaluating: false,
        results: results,
      } );
    } );
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
      <div>
        <h2>{check.name}</h2>
        <p>{check.description}</p>
        <p>{__( 'Status', 'lowtechwp' )}: {status}</p>
      </div>
    );
	};
}

export default Check;
