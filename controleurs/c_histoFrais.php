<?php
if($_REQUEST['action'] != 'pdfHisto'){
include("vues/v_sommaire.php"); }
$action = $_REQUEST['action'];
switch($action){      
            case 'histoFrais':
            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
        case 'miseAJour':
            $valider = $_REQUEST['valider'];
            foreach ($valider as $unValider)
            {
            $leMois = $pdo->setLesHistoFrais($unValider);
            $etat = 'RB';
            // $pdo->majEtatFicheFrais($unValider,$leMois['mois'],$etat);
            print_r($leMois);
            //require("./include/formMail.php");
            // EnvoieMail();
            }
            $LesHisto = $pdo->getLesHistoFrais();
            include("vues/v_histoFrais.php");
		break;
        case 'CRenCL':
            $nbCR = $pdo->getLesNbCR();
            if($nbCR>1){
            $pdo->setLesCRenCL();
            }
            include("vues/v_cloturation.php");
            break;
        case 'pdfHisto':
            $visiteur = $_REQUEST['idVisiteur'];
            $mois = $_REQUEST['mois'];
            include("vues/v_pdfFacture.php");
            break;
}
?>