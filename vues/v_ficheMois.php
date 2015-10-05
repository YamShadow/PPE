<div id="contenu">
<!-- <form name="formValidFrais" method="post" action=""> -->
	<div><h2>Frais au forfait </h2></div>
        <form action="index.php?uc=validationFrais&action=modificationFrais" method="POST">
                <table style="color:white;" border="1">
                    <tr><th>Repas midi</th><th>Nuitée </th><th>Etape</th><th>Km </th><th>Situation</th><th>Prix</th></tr>
                        
                        <tr align="center"><td width="80" ><input type="text" size="3" name="repas" value="<?php echo $lesInfo[3]['quantite'] ?>"/></td>
				<td width="80"><input type="text" size="3" name="nuitee" value="<?php echo $lesInfo[2]['quantite'] ?>"/></td> 
				<td width="80"> <input type="text" size="3" name="etape" value="<?php echo $lesInfo[0]['quantite'] ?>"/></td>
				<td width="80"> <input type="text" size="3" name="km" value="<?php echo $lesInfo[1]['quantite'] ?>"/></td>
				<td width="80">
                                    <?php if($lesInfoFrais['idEtat']== 'CL'){ ?>
                                        <select size="3" name="situ">
						<option value="E" selected>Enregistré</option>
						<option value="V">Validé</option>
						<option value="R">Remboursé</option>
                                        </select> 
                                    <?php }else if($lesInfoFrais['idEtat']== 'VA'){ ?>
                                        <select size="3" name="situ">
						<option value="E">Enregistré</option>
						<option value="V" selected>Validé</option>
						<option value="R">Remboursé</option>
					</select>
                                    <?php }else if($lesInfoFrais['idEtat']== 'RB'){ ?>
                                        <select size="3" name="situ">
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
                                <td width="300"><span style="color: black"<p>
                                            <?php echo $lesInfo[3]['libelle'].": ".$lesInfo[3]['quantite']."*prix = SOMME" ?> <br/>
                                            <?php echo $lesInfo[2]['libelle'].": ".$lesInfo[2]['quantite']."*prix = SOMME" ?> <br/> 
                                            <?php echo $lesInfo[0]['libelle'].": ".$lesInfo[0]['quantite']."*prix = SOMME" ?> <br/> 
                                            <?php echo $lesInfo[1]['libelle'].": ".$lesInfo[1]['quantite']."*prix = SOMME" ?> <br/>
                                    </span></td>
				</tr>
		</table>
            <input type="hidden" value="<?php echo $leMois ?>" name="lemois">
            <input type="hidden" value="<?php echo $idVisiteur ?>" name="idvisiteur">
            <p class="titre" /><label class="titre">&nbsp;</label><span style="float: right; padding-right: 25px"><input class="zone"type="reset" /><input class="zone"type="submit" /></span>
        </form>
		<p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
                <form action="index.php?uc=validationFrais&action=modificationHorsFrais" method="POST" >
		<table style="color:white;" border="1">
			<tr><th>Date</th><th>Libellé </th><th>Montant</th><th>Situation</th><th>Actions</th></tr>
                        <?php foreach($lesInfoHorsFrais as $unInfoHorsFrais){ ?>
			<tr align="center"><td width="100" ><input type="text" size="12" name="hfDate1" value="<?php echo $unInfoHorsFrais['date'] ?>"/></td>
				<td width="220"><input type="text" size="30" name="hfLib1" value="<?php echo $unInfoHorsFrais['libelle'] ?>"/></td> 
				<td width="90"> <input type="text" size="10" name="hfMont1" value="<?php echo $unInfoHorsFrais['montant'] ?>"/></td>
				<td width="80"> 
					<select size="3" name="hfSitu1[]">
						<option value="E">Enregistré</option>
						<option value="V">Validé</option>
						<option value="R">Remboursé</option>
					</select></td>
                                        <td width="80"><a href="index.php?uc=validationFrais&action=suppression&id=<?php echo $unInfoHorsFrais['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');"><img src="./images/icon-supprimer.jpg" title="Supprimer la ligne de frais" /></a>&nbsp&nbsp&nbsp&nbsp<a href="#">Reporter</a></td>
				</tr>
                        <?php } ?>
		</table>		
		<p class="titre"></p>
                <input type="hidden" value="<?php echo $leMois ?>" name="lemois">
                <input type="hidden" value="<?php echo $idVisiteur ?>" name="idvisiteur">
		<div class="titre">Nb Justificatifs</div><input type="text" class="zone" size="4" name="hcMontant" value="<?php echo $lesInfoFrais['nbJustificatifs']; ?>"/>		
		<p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="reset" /><input class="zone"type="submit" />
                </form>
                <!-- </form> -->
</div>