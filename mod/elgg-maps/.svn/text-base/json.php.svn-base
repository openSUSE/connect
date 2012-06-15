<?php

require('lib.php');
//gatekeeper();
$what = get_input('what');

switch($what) {
	case 'emMap.getData':
		emShowMap( get_input( 'guid' ) );
		break;
	case 'dialog.visibleMaps':
		emShowVisibleMapsList( get_input( 'guid' ) );
		break;		
	case 'dialog.mapMetadata':
		emShowMapMetadata( get_input( 'guid' ) );
		break;
	case 'dialog.map.edit':
		emShowEditMapForm( get_input( 'guid', false ) );
		break;
	case 'map.save':
		echo json_encode( array ( 'response'=> emUpdateMapAsRequestedFromAjax() ) );
		break;
	case 'user.showLoginForm':
		echo elgg_view( 'account/forms/login' );
		break;
	case  'user.isLoggedIn':
		echo json_encode( array( 'response'=> isloggedin() ) );
		break;
	case 'map.canEdit':
		if ( $map = emGetMap( get_input( 'guid' ) ) )
			echo json_encode( array( 'response'=> $map->canEdit() ) );
		break;
	case 'user.logOut':
		echo json_encode( logout() );
		break;
	default:
		echo "oops";
}

?>
