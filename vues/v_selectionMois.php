﻿ <div id="contenu">
      <h2>Validation des frais par visiteur </h2>
      <h3>Mois à sélectionner : </h3>
      <form action="http://localhost/SLAM5/PPE/Fiche-Comptable" method="post" OnChange="submit()" name="myform">
      <div class="corpsForm">
      <p> 
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			}
		   ?>    
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
         <input type="hidden" value="<?php echo $idVisiteur ?>" name="idVisiteur" >
        <input id="ok" type="submit" value="Valider" size="20"/>
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div> 
      </form>