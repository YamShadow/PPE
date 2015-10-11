<div id="contenu">
    <h2>Parie des utilisateurs</h2>
    <fieldset>
        <center><a href="http://localhost/SLAM5/PPE/Saisir-Frais" ><img src="./images/saisir.png" alt="Saisir une fiche de frais"/></a>
        <a href="http://localhost/SLAM5/PPE/Consultation" ><img src="./images/fiches.png" alt="Mes fiches de frais"/></a>
        <a href="http://localhost/SLAM5/PPE/Deconnexion" ><img src="./images/deconnexion.png" alt="Deconnexion"/></a>
        </center>
    </fieldset>
    <br/><br/><br/><br/>
     <?php
           if($_SESSION['rang'] == "Comptable")
           { ?>
        <h2>Partie des comptables</h2>
    <fieldset>
        <center><a href="http://localhost/SLAM5/PPE/Choix-Visiteur" ><img src="./images/validation.png" alt="Validation des frais"/></a>
        <a href="http://localhost/SLAM5/PPE/Historique" ><img src="./images/historique.png" alt="Historique"/></a>
        <a href="http://localhost/SLAM5/PPE/Cloturer-Fiches" ><img src="./images/cloturation.png" alt="Cloturer les fiches"/></a>
        </center>
    </fieldset>
           <?php } ?>
</div>
