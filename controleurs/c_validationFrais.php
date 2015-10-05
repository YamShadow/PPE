<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){      
        case 'selectionVisiteur':
            $lesPersonnes = $pdo->getLesInfosPersonnes();
            include("vues/v_selectionVisiteur.php");
		break;
        case 'selectionMois':
            $idVisiteur = $_POST['lstVisiteur'];
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
            include("vues/v_selectionMois.php");
            break;
        case 'affichage':
            if(isset($_POST['idVisiteur'])){
            $idVisiteur = $_POST['idVisiteur'];
            $leMois =$_POST['lstMois'];
            $lesInfoFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
            
            $lesInfo = $pdo->getLesFraisForfait($idVisiteur,$leMois);
            $lesInfoHorsFrais = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
            include("vues/v_ficheMois.php");
            }
            else{ header('location: index.php?uc=validationFrais&action=selectionVisiteur'); }     
            break;
        case 'suppression':
            $idHorsFrais = $_REQUEST['id'];
            $pdo->supprimerFraisHorsForfait($idHorsFrais);
            header('location: index.php?uc=validationFrais&action=selectionVisiteur');
            break;
        case 'modificationFrais' :
            $mois = $_REQUEST['lemois'];
            $idVisiteur = $_REQUEST['idvisiteur'];
            $keyQte = Array(
                'ETP' => $_REQUEST['etape'],
                'KM' => $_REQUEST['km'],
                'NUI' => $_REQUEST['nuitee'],
                'REP' => $_REQUEST['repas'],
            );
            $pdo->majFraisForfait($idVisiteur , $mois, $keyQte);
            if(isset($_REQUEST['situ'])){
                if($_REQUEST['situ'] == 'E'){ $etat = 'CL'; }
                else if($_REQUEST['situ'] == 'V'){ $etat = 'VA'; }
                else { $etat = 'RB'; }
                $pdo->majEtatFicheFrais($idVisiteur,$mois,$etat);
            }
            header('location: index.php?uc=validationFrais&action=selectionVisiteur');
            break;
        case 'modificationHorsFrais':
            $mois = $_REQUEST['lemois'];
            $idVisiteur = $_REQUEST['idvisiteur'];
            $nbJustificatifs = $_REQUEST['hcMontant'];
            $pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs);
            header('location: index.php?uc=validationFrais&action=selectionVisiteur');
            break;
}
?>
