const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to check for green hosting.
 */
class GreenHosting {
  constructor() {
    this.visible = true;
    this.id = 'green_hosting';
    this.name = __( 'Use a green host', 'greenerwp' );
    this.description =  __( 'Host your WordPress site on a host that uses renewable energy for its servers.', 'greenerwp' ) + ' ' +
			__( 'Have a look at the [Green Web Foundations\' green host directory](https://www.thegreenwebfoundation.org/directory/) to find a green host.', 'greenerwp' );
		this.guide = "hosting";
		this.steps = [
      {
        type: 'text',
        id: 'use_green_host',
				check: (analysis) => { return analysis.is_green_host; },
        args: {
          text: __( 'Use a host with renewable energy.', 'greenerwp' ),
					description: __( 'The recipe will be marked as done if your host is in the Green Web Foundation\'s database.', 'greenerwp' ) + ' ' +
						__( 'Will be checked at most once every day.', 'greenerwp' ),
        },
      },
    ];
  };
}

export default GreenHosting;
