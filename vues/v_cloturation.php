<div id="contenu"> 
    <?php
    $lesFiches = $_SESSION['tabExCR']; 
    $isoleMois = substr($lesFiches[1]['mois'], 4);
    $isoleAnnee = substr($lesFiches[1]['mois'], 0, -2);?>
    <h2>Fiche cloturé du <?php echo $isoleMois."/".$isoleAnnee ?></h2>
    <table border="1">
    <tr><th style="color:white;" >Nom</th>
        <th style="color:white;" >Prénom</th>
        <th style="color:white;" >Montant valide</th>
        <th style="color:white;"  >Nombre de justificatif</th>
    </tr>
    <?php
foreach ($lesFiches as $uneFiche)
    {     
        ?>
    <tr><td><?php echo $uneFiche['nom']; ?></td>
        <td><?php echo $uneFiche['prenom']; ?></td>
        <td><?php echo $uneFiche['montantValide'].'€'; ?></td>
        <td><?php echo $uneFiche['nbJustificatifs']; ?></td>
    </tr>

    <?php
    }
    ?> 
</table>
</div>