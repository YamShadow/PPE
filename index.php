<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
ini_set('display_errors','off');
if($_REQUEST['action'] != 'pdfHisto'){
include("vues/v_entete.php") ; }
session_start();
$pdo = PdoGsb::getPdoGsb();
if($_REQUEST['action'] != 'pdfHisto'){
$estConnecte = estConnecte();
if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
} }	 
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
        case 'comptable' :{
		include("controleurs/c_comptable.php");break; 
	}
        case 'validationFrais' :{
		include("controleurs/c_validationFrais.php");break; 
	}
        case 'histoFrais' :{
		include("controleurs/c_histoFrais.php");break; 
	}
        case 'accueil' :{
            if(isset($_SESSION['idVisiteur'])){
                include("vues/v_sommaire.php");
                include("vues/v_accueil.php");
            }
            else{
                header('location: index.php');
            }
        break;            
        }
}
if($_REQUEST['action'] != 'pdfHisto'){
include("vues/v_pied.php") ;
}
?>