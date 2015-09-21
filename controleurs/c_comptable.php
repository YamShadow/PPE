<?php
include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$action = $_REQUEST['action'];
switch($action){
	
        case 'fichesMois':
            include("vues/v_FichesMois.php");
		break;
}

?>