<?php
    require("fct.ini.php");
    $con = connexion();
$sql= "Select * from visiteur";
$resultat = $con->query($sql);
 while($visiteur= $resultat->fetch(PDO::FETCH_OBJ)) {   
     $id = $visiteur->id;
     $mdp = $visiteur->mdp;
     $nom = $visiteur->nom;
     $prenom = $visiteur->prenom;
    $mdpcryp = sha1($mdp);
    
$sql2 = "update visiteur set mdp='$mdpcryp' where id='$id'";
$res = $con->exec($sql2);   
 }