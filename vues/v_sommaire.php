﻿ 
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
            <label>
                <?php if($_SESSION['rang'] == "Comptable"){ ?> Comptable : <br>  <?php } else { ?> Utilisateur :<br> <?php } ?>
            </label>
            <li class="smenu">
                <?php echo $_SESSION['prenom']."  ".$_SESSION['nom'] ; ?>
            </li>
            <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li><br/>
           <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
 	   <br><br>
           <?php
           if($_SESSION['rang'] == "Comptable")
           { ?>
               <li class="smenu">
               <a href='index.php?uc=validationFrais&action=selectionVisiteur' class="btn btn-success" >Validation des frais</a>         
           </li>
           <li class="smenu">
               <a href='index.php?uc=histoFrais&action=histoFrais' class="btn btn-default" >Historique</a>
               
           </li>
           <li class="smenu">
               <a href='index.php?uc=histoFrais&action=CRenCL' class="btn btn-default" onclick="return confirm('Voulez-vous vraiment cloturer les fiches en cours ?');">Cloturer les fiches (<?php echo $nbCR ?>)</a>
               
           </li>
           <?php 
           
           
           
           }
           
           ?>
         </ul>

    </div>
    

       
