<div id="contenu">
    <h2>Historique</h2>
<table border="1">
    <tr><th style="color:white;" >Nom</th>
        <th style="color:white;" >Prénom</th>
        <th style="color:white;" >Nombre de Justificatifs</th>
        <th style="color:white;" >Montant valide</th>
        <th style="color:white;" >Date modification</th>
        <th style="color:white;">Etat</th><th style="color:white;">Valider</th>
        <th style="color:white;">Télécharger</th>
    </tr>
    
    <form method="POST" action="http://localhost/SLAM5/PPE/Mise-A-Jour-Fiches" name="inputForm">
    <?php
    $cpt = 0;
    foreach ($LesHisto as $unHisto)
    {
            $dateModif =  $unHisto['dateModif'];
            $dateModif =  dateAnglaisVersFrancais($dateModif);
            
        ?>
    <tr><td><?php echo $unHisto['nom']; ?></td>
        <td><?php echo $unHisto['prenom']; ?></td>
        <td><?php echo $unHisto['nbJustificatifs']; ?></td>
        <td><?php echo $unHisto['montantValide']; ?></td>
        <td><?php echo $dateModif; ?></td>
        <td><?php echo $unHisto['idEtat']; ?></td>
        <?php $_SESSION['histoIdVisiteur'][] = $unHisto['idVisiteur'];
            $_SESSION['histomois'][] = $unHisto['mois']; ?>
        <td><?php if( $unHisto['idEtat'] != 'RB'){ ?> <center><input type="checkbox" name="valider[]" value="<?php echo $unHisto['idVisiteur']; ?>"></center><?php } ?></td>
    <td><center><input type="image" value="<?php echo $cpt ?>" onclick="javascript:document.inputForm.submit();" name="pdf" src="images/pdf_icon.gif" /></center></td>
    </tr>

    <?php
    $cpt ++;
    }
    ?>   
    <input type='reset' name='annuler' value ='Annuler' />&nbsp&nbsp<input type='submit' name='envoyer' value ='Envoyer' /><br/><br/>
    </form>
</table>
</div>