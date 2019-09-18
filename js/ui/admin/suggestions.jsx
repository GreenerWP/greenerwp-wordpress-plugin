import CacheCheck from '../../check/cache.js';
import Check from './check.jsx';

const { __, _x, _n, _nx } = wp.i18n;

class Suggestions extends wp.element.Component {
  constructor( props ) {
    super( props );
  };

  render() {
		return (
      <Check check={new CacheCheck()}/>
		);
	};
}

module.exports = Suggestions;
