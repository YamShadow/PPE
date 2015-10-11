 
<?php 
    $nbCR = $pdo->getLesNbCR();
?>
<!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>  
</h2> 
      </div>  
        <ul id="menuList">
            <fieldset>
            <label>
                <?php if($_SESSION['rang'] == "Comptable"){ ?> Comptable : <br>  <?php } else { ?> Utilisateur :<br> <?php } ?>
            </label><br/>
            <li class="smenu">
                <?php echo $_SESSION['prenom']."  ".$_SESSION['nom'] ; ?>
            </li>
            <li class="smenu">
              <a href="http://localhost/SLAM5/PPE/Deconnexion" title="Se déconnecter">Déconnexion</a>
           </li><br/></fieldset>
            <br/>
           <fieldset><label>Création de Fiche: </label><br/><br/>
           <li class="smenu">
              <a href="http://localhost/SLAM5/PPE/Saisir-Frais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="http://localhost/SLAM5/PPE/Consultation" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li><br/></fieldset>
 	   <br><fieldset><label>Contrôle des Fiches: </label><br/><br/>
           <?php
           if($_SESSION['rang'] == "Comptable")
           { ?>
               <li class="smenu">
               <a href='http://localhost/SLAM5/PPE/Choix-Visiteur' class="btn btn-success" >Validation des frais</a>         
           </li>
           <li class="smenu">
               <a href='http://localhost/SLAM5/PPE/Historique' class="btn btn-default" >Historique</a>
               
           </li>
           <li class="smenu">
               <a href='http://localhost/SLAM5/PPE/Cloturer-Fiches' class="btn btn-default" onclick="return confirm('Voulez-vous vraiment cloturer les fiches en cours ?');">Cloturer les fiches (<?php echo $nbCR ?>)</a>
               
           </li>
           <?php 
           
           
           
           }
           
           ?>
         <br/></fieldset></ul>

    </div>
    

       
