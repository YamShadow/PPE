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
            print_r($lesInfoHorsFrais);
            include("vues/v_ficheMois.php");
            }
            else{ header('location: index.php?uc=validationFrais&action=selectionVisiteur'); }     
            break;
        case 'suppression':
                 $idHorsFrais = $_REQUEST['id'];
                 $pdo->supprimerFraisHorsForfait($idHorsFrais);
                 header('location: index.php?uc=validationFrais&action=selectionVisiteur');
            break;
}
?>
