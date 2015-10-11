<div id="contenu">
    <h2>Parie des utilisateurs</h2>
    <fieldset>
        <center>
<!--            <img src="./images/saisir.png" alt="Saisir une fiche de frais"/>-->
            <span class="saisir"><a href="http://localhost/SLAM5/PPE/Saisir-Frais" ></a></span>
        <span class="consultation"><a href="http://localhost/SLAM5/PPE/Consultation" ></a></span>
        <span class="deconnexion"><a href="http://localhost/SLAM5/PPE/Deconnexion" ></a></span>
        </center>
    </fieldset>
    <br/><br/><br/><br/>
     <?php
           if($_SESSION['rang'] == "Comptable")
           { ?>
        <h2>Partie des comptables</h2>
    <fieldset>
        <center>
        <span class="validation"><a href="http://localhost/SLAM5/PPE/Choix-Visiteur" ></a></span>
        <span class="historique"><a href="http://localhost/SLAM5/PPE/Historique" ></a></span>
        <span class="cloturation"><a href="http://localhost/SLAM5/PPE/Cloturer-Fiches" ></a></span>
        </center>
    </fieldset>
           <?php } ?>
</div>
