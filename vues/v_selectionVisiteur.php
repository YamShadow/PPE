<div id="contenu">
      <h2>Validation des frais par visiteur </h2>
      <h3>Visiteur à sélectionner : </h3>
      <form action="http://localhost/SLAM5/PPE/Choix-Mois" method="post" OnChange="submit()" name="myform">
      <div class="corpsForm">
         
      <p>
	 
        <label for="titre" accesskey="n">Visiteur : </label>
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