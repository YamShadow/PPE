<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action){      
        case 'histoFrais':
            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
        case 'miseAJour':
            $idVisiteur = $_REQUEST['valider'];
            $leMois = $pdo->setLesHistoFrais($idVisiteur);
            print_r($leMois['mois']);
            $etat = 'RB';
            $pdo->majEtatFicheFrais($idVisiteur,$leMois['mois'],$etat);
            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
            
}
?>