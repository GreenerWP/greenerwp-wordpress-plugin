const { __, _x, _n, _nx } = wp.i18n;

import Recipe from './recipe.jsx';

const Step = ( props ) => {
  var { analysis, recipe, recipes, step, onToggleStep, stepToggled } = props;
  var out = null;
  switch( step.type ) {
    case 'install_plugin':
      out = <a target="_blank" href={"plugin-install.php?s="+step.args.slug+"&tab=search&type=term"}>
        { sprintf( __( "Install and activate %s", "greenerwp" ), step.args.name ) }
      </a>;
      break;
    case 'link':
      out = <><a target="_blank" href={step.args.href}>
        {step.args.text}
      </a><br/>{step.args.description}</>;
      break;
    case 'recipe':
      out = <Recipe {...props} recipe={recipes[step.args.recipe]}/>;
      break;
    default:
      throw Error( "Unknown recipe type: " + step.type );
  };
	var hasCheck = 'check' in step;
	var isChecked = hasCheck && step.check( analysis )
							 || stepToggled[recipe.id + '.' + step.id] || false;
  return (
    <li>{ step.type !== 'recipe' ? <input type="checkbox" disabled={ hasCheck } onChange={(event)=>{onToggleStep(recipe.id, step.id)}} checked={ isChecked } /> : null } { out }</li>
  );
};

export default Step;
