﻿<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbV2';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
                $mdpcrypt = sha1($mdp);
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, visiteur.rang as rang from visiteur 
		where visiteur.login='$login' and visiteur.mdp='$mdpcrypt'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CR' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
                print_r($dateFr);
		try{
                $req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant', NULL, 0)";
                PdoGsb::$monPdo->exec($req);}
                catch(Exception $e){
                    echo 'Exception recu : ', $e->getMessage(), "\n";
                }
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois ='$mois'";
		PdoGsb::$monPdo->exec($req);
	}
        
        /**
         * Retourne les informations contenu dans la table visiteur.
         * @return un tableau qui contient les valeurs que retourne la requête.
         */
        
	public function getLesInfosPersonnes(){
		$req = "select * from visiteur order by nom ASC";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetchAll();
		return $laLigne;
	}
        
        /**
         * Retourne les fiches de frais appartenent au mois entrer en parametre.
         * @param $date : mois sour forme AAAAMM.
         * @return un tableau qui contient les valeurs que retourne la requête.
         */

        public function getFichesMoisEnCours($date)
        {
                $req = "select * from fichefrais where mois = '$date'
                        and idEtat = 'CR'";
                $res = PdoGsb::$monPdo->query($req);
		$tabCR = $res->fetch();
		return $tabCR;
        }
        
        /**
         * Retourne les fiches de frais dont l'idEtat est égale à VA ou RB.
         * @return un tableau qui contient les valeurs que retourne la requête.
         */
        
        public function getLesHistoFrais()
        {
                $req = "select * from fichefrais FF join visiteur v on v.id = FF.idVisiteur where idEtat = 'VA' or idEtat = 'RB' order by idEtat DESC , dateModif DESC ";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetchAll();
		return $laLigne;
        }
        /**
         * Retourne les fiches de frais dont l'idEtat est égale à VA et l'idVisiteur est égale à la variable entrer en parametre.
         * @param $valider : Contient un id referent a la table visiteur.
         * @return un tableau qui contient les valeurs que retourne la requête.
         */
        public function setLesHistoFrais($valider)
        {  
                $mois = "select mois from fichefrais where idVisiteur='$valider' and idEtat='VA' ";
                $resMois = PdoGsb::$monPdo->query($mois);
                $laLigne = $resMois->fetch();
                return $laLigne;
        }
        /**
         * Retourne le nombre de fiches frais dont idEtat est égale à CR
         * @return un entier.
         */
        public function getLesNbCR()
        {
                $req = "select * from fichefrais where idEtat = 'CR'";
		$res = PdoGsb::$monPdo->query($req);
                $count = $res->rowCount();
		return $count;
        }
        /**
         * Met à jour les idEtat égale à CR en CL.
         */
        public function setLesCRenCL()
        {
                $req = "select * from fichefrais FF join visiteur V ON FF.idVisiteur = V.id where idEtat = 'CR'";
                $res = PdoGsb::$monPdo->query($req);
                $laLigne = $res->fetchAll();                 
                $req2 = "update ficheFrais set idEtat = 'CL', dateModif = now() where idEtat = 'CR'";
                PdoGsb::$monPdo->exec($req2);
                $_SESSION['tabExCR'] = $laLigne; 
        }
        /**
         * Retourne le contenu de la table fraisforfait.
         * @return un tableau qui contient les valeurs que retourne la requête.
         */
        public function getLesMontantFrais(){
            
                $req = "select * from fraisforfait";
                $res = PdoGsb::$monPdo->query($req);
                $laLigne = $res->fetchAll();
                return $laLigne;
        }
        /**
         * Met à jour la table lignefraishorsforfait avec les parametre d'entrer ci dessus.
         * @param entier $idVisiteur
         * @param entier $mois
         * @param entier $unIdFrais
         * @param double $montant
         * @param caractere $libelle
         * @param date $date
         */
        public function majHorsFrais($idVisiteur, $mois, $unIdFrais, $montant, $libelle, $date){
	
                $req = "update lignefraishorsforfait set lignefraishorsforfait.libelle = '$libelle',
                        lignefraishorsforfait.montant = '$montant', lignefraishorsforfait.date = '$date' 
                        where lignefraishorsforfait.idvisiteur = '$idVisiteur' and lignefraishorsforfait.mois = '$mois'
                        and lignefraishorsforfait.id = '$unIdFrais'";
                PdoGsb::$monPdo->exec($req);	
	}
        /**
         * Incremente le montant après avoir validé les fraisforfait.
         * @param entier $idVisiteur
         * @param entier $mois
         * @param double $montant
         */
        public function setMontantFrais($idVisiteur, $mois, $montant){
                
                $req = "update fichefrais set fichefrais.montantValide = '$montant'
                        where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
                PdoGsb::$monPdo->exec($req);
        }
        /**
         * Supprime les frais hors forfait de la partie comptable en modifient le libellé à SUPPRIMER.
         * @param entier $idFrais
         * @param caractere $libelle
         */
       public function supprimerFraisHorsForfaitComptable($idFrais, $libelle){
                $req = "update lignefraishorsforfait set lignefraishorsforfait.libelle = '$libelle', 
                        lignefraishorsforfait.supprimer = '1'
                        where lignefraishorsforfait.id =$idFrais ";
                PdoGsb::$monPdo->exec($req);
	}
        /**
         * Met à jour la payer à 1 selon l'id entrer en parametre, cette ligne à donc était payer. 
         * @param entier $id
         */
        
        public function horsFraisPayer($id){
                $req="update lignefraishorsforfait set lignefraishorsforfait.payer = 1
                        where lignefraishorsforfait.id = $id";
                PdoGsb::$monPdo->exec($req);      
        }
        /**
         * Met à jour le mois dans la table lignefraishorsforfait.
         * @param entier $idFrais
         * @param entier $mois
         */
        
        function majMoisHorsFrais($idFrais, $mois){
                $req = "update lignefraishorsforfait set lignefraishorsforfait.mois = '$mois'
                        where lignefraishorsforfait.id = $idFrais";
                PdoGsb::$monPdo->exec($req);
           }
           /**
            * Genere une facture en pdf par rapport aux variables d'entrer.
            * @param entier $visiteur
            * @param entier $mois
            */
        function creationFacturePDF($visiteur,$mois)
        {
            ob_end_clean();
            $req = "select * from visiteur where id ='".$visiteur."'";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            
            $nom = $laLigne['nom'];
            $prenom = $laLigne['prenom'];
            $adresse = $laLigne['adresse'];
            $cp = $laLigne['cp'];
            $ville = $laLigne['ville'];
            
            $req2 = "select dateModif from fichefrais where idVisiteur ='".$visiteur."' and mois ='".$mois."'";
            $res2 = PdoGsb::$monPdo->query($req2);
            $laLigne2 = $res2->fetch();
            
            
            $dateModif = $laLigne2[0];
            $isoleJours = substr($dateModif, 8);
            $isoleMois = substr($dateModif, 5, -3);
            $isoleAnnee = substr($dateModif, 0, -6);
            $dateModif = $isoleJours."/".$isoleMois."/".$isoleAnnee;
            
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            
            $moisEtAnnee = ''.$numMois.'/'.$numAnnee.'';
            
            $req3 = "select fraisforfait.libelle, fraisforfait.montant, lignefraisforfait.quantite from fraisforfait join lignefraisforfait on idFraisForfait = id where idVisiteur ='".$visiteur."' and mois ='".$mois."'";
            $res3 = PdoGsb::$monPdo->query($req3);
            $tabForfaitaires = $res3->fetchAll();
            $req4 = "select libelle, montant, date, supprimer from lignefraishorsforfait where idVisiteur ='".$visiteur."' and mois =".$mois."";
            $res4 = PdoGsb::$monPdo->query($req4);
            $tabHorsFrais = $res4->fetchAll();
            //foreach date anglais
            
            require('C:\wamp\www\SLAM5\PPE\fpdf\fpdf.php');

            $pdf=new FPDF();

            $pdf->AddPage();

            $pdf->SetAutoPageBreak(true, 0.00);

            $pdf->SetFont('times','B',10);

            $pdf->SetXY(10, 5);
            $pdf->Cell(10,5,'',0,0,'L',$pdf->Image('./images/fpdf/logo.jpg',5,5,30,30));

            $pdf->SetXY(37,10);
            $pdf->Cell(30,5,"Laboratoire Galaxy Swiss Bourdin",0,0,'L');
            $pdf->Ln();
            $pdf->SetXY(37,15);
            $pdf->Cell(30,5,utf8_decode("176 rue Galliéni"),0,0,'L');
            $pdf->Ln();
            $pdf->SetXY(37,20);
            $pdf->Cell(30,5,"75008 Paris",0,0,'L');
            $pdf->Ln();

              $nb = $pdf->GetStringWidth("".$dateModif."") + $pdf->GetStringWidth("Date d'édition : ");
            $pdf->SetXY(150,20);
            $pdf->Cell($nb,5,utf8_decode("Date d'édition : ".$dateModif.""),0,0,'L');
            $pdf->Ln();

            $pdf->SetFont('Arial','',8);

            $pdf->SetDrawColor(18,62,106);
            $pdf->Rect(120, 40, 70, 25,'D');

            $nb1 = $pdf->GetStringWidth("".$nom."") + 2;
            $pdf->SetXY(125,45);
            $pdf->Cell($nb1,5,utf8_decode($nom),0,0,'L');

            $nb2 = $pdf->GetStringWidth("".$prenom."") + 2;
            $pdf->SetXY(125+$nb1,45);
            $pdf->Cell($nb2,5,utf8_decode($prenom),0,0,'L');


            $nb3 = $pdf->GetStringWidth("".$adresse."") + 2;
            $pdf->SetXY(125,50);
            $pdf->Cell($nb3,5,utf8_decode($adresse),0,0,'L');

            $nb3 = $pdf->GetStringWidth("".$cp." ".$ville."") + 2;
            $pdf->SetXY(125,55);
            $pdf->Cell($nb3,5,utf8_decode("".$cp." ".$ville.""),0,0,'L');

            $pdf->SetFont('Arial','B',10);

            $pdf->SetXY(75,80);
            $pdf->Cell(5,5,utf8_decode("Facture des frais engagés du ".$moisEtAnnee.""),0,0,'L');
            $pdf->Ln();
            $pdf->Ln();

	//Tableau Forfaitaires et Hors forfaits
            //Tableau forfaitaires
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(30,5,"Frais forfait :",0,0,'L');
            $pdf->Ln();
            $w = array(90, 35, 35, 35);
            $header = array('Libellé', 'Montant unitaire', 'Quantité', 'Montant total');
            for($i=0; $i<count($header); $i++){
                $pdf->SetFillColor(102, 163, 211);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell($w[$i], 7,utf8_decode($header[$i]), 1,0,'C' , true);
            }
            $pdf->SetTextColor(0,0,0);
            $pdf->Ln();
            $fill= false;
            $montantFrais = 0;
            foreach($tabForfaitaires as $col)
            {
                $pdf->Cell($w[0],6,utf8_decode($col['0']),'LR', 0, 'L', $fill);
                $pdf->Cell($w[1],6,utf8_decode($col['1']." euros"),'LR', 0, 'L', $fill);
                $pdf->Cell($w[2],6,utf8_decode($col['2']),'LR', 0, 'L', $fill);
                $pdf->Cell($w[3],6,utf8_decode($col['2']*$col['1']." euro"),'LR', 0, 'L', $fill);
                $montantFrais += $col['2']*$col['1'];
                
                $pdf->Ln();
            }
            $pdf->Cell(array_sum($w),5,'','T');
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"Montant des frais forfait : ".$montantFrais." euros",0,0,'L');
            $pdf->Ln();
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(30,5,"Frais hors forfait :",0,0,'L');
            $pdf->Ln();
            $header2 = array('Date', 'Libellé', 'Montant');
            $w = array(35, 125, 35);
            for($i=0; $i<count($header2); $i++){
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell($w[$i], 7,utf8_decode($header2[$i]), 1,0,'C', true);
            }
            $pdf->SetTextColor(0,0,0);
            $pdf->Ln();
            $montantHorsFrais = 0;
            foreach($tabHorsFrais as $col2)
            {
                $isoleJours = substr($col2['2'], 8);
                $isoleMois = substr($col2['2'], 5, -3);
                $isoleAnnee = substr($col2['2'], 0, -6);
                $col2['2'] = $isoleJours."/".$isoleMois."/".$isoleAnnee;
                $pdf->Cell($w[0],6,utf8_decode($col2['2']),'LR', 0, 'L', $fill);
                $pdf->Cell($w[1],6,utf8_decode($col2['0']),'LR', 0, 'L', $fill);
                $pdf->Cell($w[2],6,utf8_decode($col2['1']." euros"),'LR', 0, 'L', $fill);
                if($col2['supprimer'] != 1){
                $montantHorsFrais += $col2['1']; }
                $pdf->Ln();
            }
            $pdf->Cell(array_sum($w),5,'','T');
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,10,"Montant des frais hors forfait : ".$montantHorsFrais." euros",0,0,'L');
            $pdf->Ln();

//            $pdf->SetFont('Arial','',7);
//            $pdf->SetXY(0,227);
//            $pdf->Cell(0,30,utf8_decode("Comment régler ?"));
//            $pdf->SetXY(0,230);
//            $pdf->Cell(0,30,utf8_decode("Adressez votre chèque"));
//            $pdf->SetXY(0,233);
//            $pdf->Cell(0,30,utf8_decode("ou votre mandat à"));
//            $pdf->SetXY(0,236);
//            $pdf->Cell(0,30,utf8_decode("l'adresse de la boite"));
//            $pdf->SetXY(0,239);
//            $pdf->Cell(0,30,utf8_decode("postale ci dessous."));
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Rect(1, 260, 25, 20,'D');
//
//            $pdf->SetFont('times','B',5);
//
//            $pdf->SetXY(1,250);
//            $pdf->Cell(0,30,utf8_decode("LABORATOIRE GSB"));
//            $pdf->SetXY(1,252);
//            $pdf->Cell(0,30,utf8_decode("BTTF - Centre de traitement"));
//            $pdf->SetXY(1,254);
//            $pdf->Cell(0,30,utf8_decode("TSA 270"));
//            $pdf->SetXY(1,258);
//            $pdf->Cell(0,30,utf8_decode("93270 SEVRAN CEDEX"));

            $pdf->Rect(27, 235, 190, 80,'');
            $pdf->Rect(27, 280, 190, 80,'');
            $pdf->Rect(27, 235, 190, 45,'');

            $pdf->SetXY(10, 5);
            $pdf->Cell(10,5,'',0,0,'L',$pdf->Image('./images/fpdf/logo.jpg',30,238,20,20));


            $pdf->SetFont('times','',8);
            $pdf->SetXY(60,225);
            $pdf->Cell(0,30,utf8_decode("LABORATOIRE GSB"));
            $pdf->SetXY(60,228);
            $pdf->Cell(0,30,utf8_decode("BTTF - Centre de traitement"));
            $pdf->SetXY(60,231);
            $pdf->Cell(0,30,utf8_decode("TSA 270"));
            $pdf->SetXY(60,234);
            $pdf->Cell(0,30,utf8_decode("93270 SEVRAN CEDEX"));

            $nb1 = $pdf->GetStringWidth("".$nom."") + 2;
            $pdf->SetXY(80,260);
            $pdf->Cell($nb1,5,utf8_decode($nom),0,0,'L');

            $nb2 = $pdf->GetStringWidth("".$prenom."") + 2;
            $pdf->SetXY(80+$nb1,260);
            $pdf->Cell($nb2,5,utf8_decode($prenom),0,0,'L');

            $pdf->SetXY(80,263);
            $pdf->Cell(0,30,utf8_decode("Talon de validation des remboursements"));

            $montant = $montantFrais+$montantHorsFrais;

            $pdf->SetFont('times','B',8);

            $nb3 = $pdf->GetStringWidth("".$montant."") + 2;
            $pdf->SetXY(170,270);
            $pdf->Cell($nb3,5,utf8_decode("".$montant.""),0,0,'L');

            $pdf->SetXY(10, 5);
            $pdf->Cell(10,5,'',0,0,'L',$pdf->Image('images/fpdf/logo_cheque.jpg',180,260,10,10));
            $pdf->Cell(10,5,'',0,0,'L',$pdf->Image('images/signature.jpg',140,247,30,30));

            $pdf->SetFont('times','B',12);

            $m = str_replace ('.', '', $montant);

            $pdf->SetXY(80,290);
            $pdf->Cell(0,5,utf8_decode("874694000035     552159540084774687946212684521   ".$m.""),0,0,'L');

            $pdf->SetXY(0,180);
            $pdf->Cell(0,100,'',0,0,'L',$pdf->Image('images/fpdf/ciseau.jpg',30,223,180,15));

            $pdf->Output();        
        }
}
?>
