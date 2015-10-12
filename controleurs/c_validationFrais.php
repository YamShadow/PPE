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
            $res = $pdo->dernierMoisSaisi($idVisiteur);
            $leMois =$_POST['lstMois'];
            $lesInfoFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
            $infoMontant = $pdo->getLesMontantFrais();
           
            $lesInfo = $pdo->getLesFraisForfait($idVisiteur,$leMois);
            $lesInfoHorsFrais = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois); 
            include("vues/v_ficheMois.php");
            }
            else{ header('location: http://localhost/SLAM5/PPE/Choix-Visiteur'); }     
            break;
        case 'suppression':
            $idHorsFrais = $_REQUEST['id'];
            $libelle = "SUPPRIMER - ".$_REQUEST['libelle'];
            $pdo->supprimerFraisHorsForfaitComptable($idHorsFrais, $libelle);
            header('location: http://localhost/SLAM5/PPE/Choix-Visiteur');
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
                else if($_REQUEST['situ'] == 'V'){ $etat = 'VA';
                $lesInfoFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
                $montant = $lesInfoFrais['montantValide']+$_REQUEST['montant'];
                $pdo->setMontantFrais($idVisiteur, $mois, $montant);
                }
                else { $etat = 'RB';
                $lesInfoFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
                $montant = $lesInfoFrais['montantValide']+$_REQUEST['montant'];
                $pdo->setMontantFrais($idVisiteur, $mois, $montant);
                }
                $pdo->majEtatFicheFrais($idVisiteur,$mois,$etat);
            }
            header('location: http://localhost/SLAM5/PPE/Choix-Visiteur');
            break;
        case 'modificationHorsFrais':
            $libelle = $_REQUEST['hfLib1'];
            $montant = $_REQUEST['hfMont1'];
            $idVisiteur = $_REQUEST['idvisiteur'];
            $mois = $_REQUEST['lemois'];
            $idHorsFrais = $_REQUEST['idHorsFrais'];         
            $lesSituations = $_REQUEST['hfSitu1'];
            $dateFrais = $_REQUEST['hfDate1'];
                    $cpt = 0;
                    foreach($dateFrais as $uneDateFrais){
                        $dateFrais[$cpt] = dateFrancaisVersAnglais($uneDateFrais);
                        $cpt ++;
                    } 
            $cpt = 0;
            foreach($idHorsFrais as $unIdHorsFrais){
                
            $pdo->majHorsFrais($idVisiteur, $mois, $unIdHorsFrais, $montant[$cpt], $libelle[$cpt], $dateFrais[$cpt]);
            if($_REQUEST['bool'][$cpt] != 1 && $lesSituations[$cpt] == 'V' && $_REQUEST['payer'][$cpt] !=1){
                $lesInfoFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
                $montant = $lesInfoFrais['montantValide']+$_REQUEST['hfMont1'][$cpt];
                $pdo->setMontantFrais($idVisiteur, $mois, $montant);
                $pdo->horsFraisPayer($unIdHorsFrais);
                   }
                 $cpt ++;
            }
           
            $nbJustificatifs = $_REQUEST['hcMontant'];
            $pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs);
            header('location: http://localhost/SLAM5/PPE/Choix-Visiteur');
            break;
            
        case 'reportMois':
            $idFrais = $_REQUEST['id'];
            $mois = $_REQUEST['mois'];
            $isoleMois = substr($mois, 4);
            $isoleAnnee = substr($mois, 0, -2);
            if($isoleMois < 12){
                $isoleMois ++;
                if($isoleMois<10){ $isoleMois = "0".$isoleMois; }
                $mois = $isoleAnnee.''.$isoleMois;
            }
            else{
                $isoleAnnee ++;
                $isoleMois = '01';
                $mois = $isoleAnnee.''.$isoleMois;        
            }
            $pdo->majMoisHorsFrais($idFrais, $mois);
             header('location: http://localhost/SLAM5/PPE/Choix-Visiteur');
            break;
}
?>