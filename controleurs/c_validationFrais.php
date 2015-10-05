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
        case 'Affichage':
            $idVisiteur = $_POST['idVisiteur'];
            $leMois =$_POST['lstMois'];
            $lesInfo = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
            include("vues/v_ficheMois.php");
            break;
}
?>
