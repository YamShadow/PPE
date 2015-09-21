<?php
if(!isset($_REQUEST['comptable'])){
	$_REQUEST['comptable'] = 'demandeConnexion';
}
$comptable = $_REQUEST['comptable'];

switch($comptable){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>