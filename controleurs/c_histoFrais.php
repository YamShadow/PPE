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
            if(isset($_REQUEST['pdf'])){
                $_SESSION['cpt'] = $_REQUEST['pdf'];
                header('location: http://localhost/SLAM5/PPE/PDF');
            }
            $valider = $_REQUEST['valider'];
            foreach ($valider as $unValider)
            {
            $leMois = $pdo->setLesHistoFrais($unValider);
            $etat = 'RB';
            $pdo->majEtatFicheFrais($unValider,$leMois['mois'],$etat);
//            require("./include/formMail.php");
//            EnvoieMail();
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
            $cptPDF  = $_SESSION['cpt'];
            $visiteur = $_SESSION['histoIdVisiteur'][$cptPDF];
            $mois = $_SESSION['histomois'][$cptPDF];
            $cptPDF  = $_SESSION['cpt'];
            include("vues/v_pdfFacture.php");
            break;
}
?>