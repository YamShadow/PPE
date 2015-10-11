<div id="contenu">
<!-- <form name="formValidFrais" method="post" action=""> -->
	<div><h2>Frais au forfait </h2></div>
        <form action="http://localhost/SLAM5/PPE/Modification-Frais-Comptable" method="POST">
                <table style="color:white;" border="1">
                    <tr><th>Repas midi</th><th>Nuitée </th><th>Etape</th><th>Km </th><th>Situation</th><th>Prix</th></tr>
                        
                        <tr><td align=center width="80" ><input type="text" size="3" name="repas" <?php if($lesInfoFrais['idEtat']== 'VA' || $lesInfoFrais['idEtat']== 'RB') { ?> disabled="disabled" <?php } ?> value="<?php echo $lesInfo[3]['quantite'] ?>"/></td>
				<td align=center width="80"><input type="text" size="3" name="nuitee" <?php if($lesInfoFrais['idEtat']== 'VA' || $lesInfoFrais['idEtat']== 'RB') { ?> disabled="disabled" <?php } ?> value="<?php echo $lesInfo[2]['quantite'] ?>"/></td> 
				<td align=center width="80"> <input type="text" size="3" name="etape" <?php if($lesInfoFrais['idEtat']== 'VA' || $lesInfoFrais['idEtat']== 'RB') { ?> disabled="disabled" <?php } ?> value="<?php echo $lesInfo[0]['quantite'] ?>"/></td>
				<td align=center width="80"> <input type="text" size="3" name="km" <?php if($lesInfoFrais['idEtat']== 'VA' || $lesInfoFrais['idEtat']== 'RB') { ?> disabled="disabled" <?php } ?> value="<?php echo $lesInfo[1]['quantite'] ?>"/></td>
				<td align=center width="80">
                                    <?php if($lesInfoFrais['idEtat']== 'CL'){ ?>
                                        <select size="3" name="situ">
						<option value="E" selected>Enregistré</option>
						<option value="V">Validé</option>
						<option value="R">Remboursé</option>
                                        </select> 
                                    <?php }else if($lesInfoFrais['idEtat']== 'VA'){ ?>
                                        <select size="3" name="situ" disabled="disabled" >
						<option value="E">Enregistré</option>
						<option value="V" selected>Validé</option>
						<option value="R">Remboursé</option>
					</select>
                                    <?php }else if($lesInfoFrais['idEtat']== 'RB'){ ?>
                                        <select size="3" name="situ" disabled="disabled">
						<option value="E">Enregistré</option>
						<option value="V">Validé</option>
						<option value="R" selected>Remboursé</option>
					</select>
                                    <?php }else { ?>
					<select size="3" name="situ">
						<option value="E">Enregistré</option>
						<option value="V">Validé</option>
						<option value="R">Remboursé</option>
					</select>
                                    <?php } ?></td>
                                <td width="300"><span style="color: black; float: left; padding-left:5px"<p>
                                            <?php echo $lesInfo[3]['libelle'].": ".$lesInfo[3]['quantite']."*".$infoMontant[3]['montant']."€ = <strong>".$lesInfo[3]['quantite']*$infoMontant[3]['montant']."€</strong>" ?> <br/>
                                            <?php echo $lesInfo[2]['libelle'].": ".$lesInfo[2]['quantite']."*".$infoMontant[2]['montant']."€ = <strong>".$lesInfo[2]['quantite']*$infoMontant[2]['montant']."€</strong>" ?> <br/> 
                                            <?php echo $lesInfo[0]['libelle'].": ".$lesInfo[0]['quantite']."*".$infoMontant[0]['montant']."€ = <strong>".$lesInfo[0]['quantite']*$infoMontant[0]['montant']."€</strong>" ?> <br/> 
                                            <?php echo $lesInfo[1]['libelle'].": ".$lesInfo[1]['quantite']."*".$infoMontant[1]['montant']."€ = <strong>".$lesInfo[1]['quantite']*$infoMontant[1]['montant']."€</strong>" ?> <br/>
                                            <?php $montant = ($lesInfo[3]['quantite']*$infoMontant[3]['montant'])+ ($lesInfo[2]['quantite']*$infoMontant[2]['montant']) + ($lesInfo[0]['quantite']*$infoMontant[0]['montant']) + ($lesInfo[1]['quantite']*$infoMontant[1]['montant']) ; ?>
                                    </span></td>
				</tr>
		</table>
            <input type="hidden" value="<?php echo $leMois ?>" name="lemois">
            <input type="hidden" value="<?php echo $idVisiteur ?>" name="idvisiteur">
            <input type="hidden" value="<?php echo $montant ?>" name="montant">
            <p class="titre" /><label class="titre">Montant total des frais forfaits : <strong><?php echo $montant ?>€</strong></label> <?php if($lesInfoFrais['idEtat']== 'CR' || $lesInfoFrais['idEtat']== 'CL') { ?><span style="float: right; padding-right: 25px"><input class="zone"type="reset" /><input class="zone"type="submit" /></span><?php } ?>
        </form>
		<p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
                <?php $montantHF = 0; ?>
                <form action="http://localhost/SLAM5/PPE/Modification-Hors-Frais-Comptable" method="POST" >
		<table style="color:white;" border="1">
			<tr><th>Date</th><th>Libellé </th><th>Montant</th><th>Situation</th><th>Actions</th></tr>
                        <?php foreach($lesInfoHorsFrais as $unInfoHorsFrais){ ?>
                        <input type="hidden" name="bool[]" value="<?php echo $unInfoHorsFrais['supprimer'] ?>">
                        <input type="hidden" name="payer[]" value="<?php echo $unInfoHorsFrais['payer'] ?>">
                        <input type="hidden" name="idHorsFrais[]" value="<?php echo $unInfoHorsFrais['id'] ?>">
			<tr align="center"><td width="80" ><input type="text" size="10" name="hfDate1[]"  value="<?php echo $unInfoHorsFrais['date'] ?>"/></td>
                                <td width="280"><input type="text" size="37" name="hfLib1[]" value="<?php echo $unInfoHorsFrais['libelle'] ?>"/></td> 
				<td width="50"> <input type="text" size="8" name="hfMont1[]" value="<?php echo $unInfoHorsFrais['montant'] ?>"/></td>
                                <?php if($unInfoHorsFrais['supprimer'] != 1) { $montantHF += $unInfoHorsFrais['montant']; } ?>
                                <td width="100"> 
                                    <select size="3" name="hfSitu1[]">
						<option value="E" <?php if( $unInfoHorsFrais['payer'] != 1) { ?> selected <?php } ?>>Non payer</option>
						<option value="V" <?php if( $unInfoHorsFrais['payer'] == 1) { ?> selected <?php } ?>>Payer</option>
                                </select></td>
                                <td width="120"><?php if($unInfoHorsFrais['supprimer'] != 1 || $unInfoHorsFrais['payer'] == 1) { ?><a href="index.php?uc=validationFrais&action=suppression&id=<?php echo $unInfoHorsFrais['id'] ?>&libelle=<?php echo $unInfoHorsFrais['libelle'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');"><img src="./images/icon-supprimer.jpg" title="Supprimer la ligne de frais" /></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="index.php?uc=validationFrais&action=reportMois&id=<?php echo $unInfoHorsFrais['id'] ?>&mois=<?php echo $unInfoHorsFrais['mois'] ?>" onclick="return confirm('Voulez-vous vraiment reporter ce frais?');"><img src="./images/report-icon.png" title="reporter le frais  />"</a><?php } ?></td>
				</tr>
                        <?php } ?>
		</table>		
                    <p class="titre"><label class="titre">Montant total des frais hors forfaits : <strong><?php echo $montantHF ?>€ </label></strong></p>
                <input type="hidden" value="<?php echo $leMois ?>" name="lemois">
                <input type="hidden" value="<?php echo $idVisiteur ?>" name="idvisiteur">
                <div class="titre">Nb Justificatifs: &nbsp;<input type="text" align="right" class="zone" size="4" name="hcMontant" value="<?php echo $lesInfoFrais['nbJustificatifs']; ?>"/></div>		
                <p class="titre" /><span style="float: right; padding-right: 25px"><input class="zone"type="reset" /><input class="zone"type="submit" /></span>
                </form>
                <!-- </form> -->
</div>