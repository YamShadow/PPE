<div id="contenu">
    <h2>Historique</h2>
<table border="1">
    <tr><th style="color:white;" >Identifiant</th>
        <th style="color:white;" >Nombre de Justificatifs</th>
        <th style="color:white;" >Montant valide</th>
        <th style="color:white;" >Date modification</th>
        <th style="color:white;">Etat</th><th style="color:white;">Valider</th>
        <th style="color:white;">Télécharger</th>
    </tr>
    
    <form method="POST" action="http://localhost/SLAM5/PPE/Mise-A-Jour-Fiches">
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
    <input type='reset' name='annuler' value ='Annuler' />&nbsp&nbsp<input type='submit' name='envoyer' value ='Envoyer' /><br/><br/>
    </form>
</table>
</div>