<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action){      
        case 'histoFrais':
            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
        case 'miseAJour':
            $valider = $_REQUEST['valider'];
            $mois = $_REQUEST['mois'];
            $LesHisto = $pdo->setLesHistoFrais($valider,$mois);
            include("vues/v_histoFrais.php");
		break;
            
}
?>