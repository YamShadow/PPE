
<table>
    <tr><td>Identifiant</td><td>Nombre de Justificatifs</td><td>Montant valide</td><td>Date modification</td>
        <td>Etat</td><td>Valider</td><td>Télécharger</td></tr>
    
    <form action="?">
    <?php
    foreach ($LesHisto as $unHisto)
    {
        ?>
     
    <tr><td><?php echo $unHisto['idVisiteur']; ?></td><td><?php echo $unHisto['nbJustificatifs']; ?></td><td><?php echo $unHisto['montantValide']; ?></td><td><?php echo $unHisto['dateModif']; ?></td>
        <td><?php echo $unHisto['idEtat']; ?></td><td><input type="checkbox" name="valider[]" value="<?php echo $unHisto['idVisiteur']; ?>"></td><td><a href = '' > <img src = 'images/pdf_icon.gif' border = '0'></a></td></tr>
    
   
    
     
     
   
    
    <?php
    }
    ?>   
    <input type='reset' name='annuler' value ='Annuler' /><input type='submit' name='envoyer' value ='Envoyer' />
    </form>
</table>