<?php
    require("fct.ini.php");
    $con = connexion();

$sql= "Select * from visiteur";
$resultat = $con->query($sql);

 while($visiteur= $resultat->fetch(PDO::FETCH_OBJ)) {
     
     $mdp = $visiteur->mdp;
     $nom = $visiteur->nom;
     $prenom = $visiteur->prenom;
     
    
    $mdpcryp = sha1($mdp);
    
    echo "Membre ".$nom." ".$prenom." avec le mdp :".$mdp."<br/>";
    echo "New mot de passe crypté: ".$mdpcryp."<br/>";
    echo "<br/>";
     
     
 }