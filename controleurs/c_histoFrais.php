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
            // print_r($valider);
            $pdo->setLesHistoFrais($valider);

            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
            
}
?>