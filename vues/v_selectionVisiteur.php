<div id="contenu">
      <h2>Validation des frais par visiteur </h2>
      <h3>Visiteur à sélectionner : </h3>
      <form action="index.php?uc=validationFrais&action=selectionMois" method="post" name="formValidSelectionVisiteur">
      <div class="corpsForm">
         
      <p>
	 
        <label for="titre" accesskey="n">Mois : </label>
        <select id="lstVisiteur" name="lstVisiteur">
            <?php foreach($lesPersonnes as $unPersonne){ ?>
                <option value="<?php echo $unPersonne['id'] ?>"><?php echo $unPersonne['nom'] ?></option>

            <?php } ?>
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>