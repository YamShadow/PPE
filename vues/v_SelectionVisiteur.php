<div id="contenu">
<form name="formValidSelectionVisiteur" method="post" action="index.php?uc=validationFrais&action=">
<h1> Validation des frais par visiteur </h1>
<label class="titre">Choisir le visiteur :</label><select name="lstVisiteur" class="zone">
<?php foreach($lesPersonnes as $unPersonne){ ?>
<option value="<?php echo $unPersonne['id'] ?>"><?php echo $unPersonne['nom'] ?></option>

<?php } ?>
</select><br/><br/>
<span style='float: right'><input type="submit" name="submit" value="Valider" ></span>
</form>
</div>