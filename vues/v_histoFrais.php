<div id="contenu">
<table border ="1">
    <tr><td>Identifiant</td>
        <td>Nombre de Justificatifs</td>
        <td>Montant valide</td>
        <td>Date modification</td>
        <td>Etat</td><td>Valider</td>
        <td>Télécharger</td>
    </tr>
    
    <form method="POST" action="index.php?uc=histoFrais&action=miseAJour">
    <?php
    foreach ($LesHisto as $unHisto)
    {
            $dateModif =  $unHisto['dateModif'];
            $dateModif =  dateAnglaisVersFrancais($dateModif);
            
        ?>
    <tr><td><?php echo $unHisto['idVisiteur']; ?></td>
        <td><?php echo $unHisto['nbJustificatifs']; ?></td>
        <td><?php echo $unHisto['montantValide']; ?></td>
        <td><?php echo $dateModif; ?></td>
        <td><?php echo $unHisto['idEtat']; ?></td>
        <td><?php if( $unHisto['idEtat'] != 'RB'){ ?> <center><input type="checkbox" name="valider[]" value="<?php echo $unHisto['idVisiteur']; ?>"></center><?php } ?></td>
        <td><center><a href = '' > <img src = 'images/pdf_icon.gif' border = '0'></a></center></td>
    </tr>

    <?php
    }
    ?>   
    <input type='reset' name='annuler' value ='Annuler' />&nbsp&nbsp&nbsp&nbsp<input type='submit' name='envoyer' value ='Envoyer' /><br/><br/>
    </form>
</table>
</div>