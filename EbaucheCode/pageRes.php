<?php
echo $_REQUEST['q'];
echo '<br/>';
echo $_REQUEST['image'];

<?php if($unInfoHorsFrais['supprimer'] != 1 || $unInfoHorsFrais['payer'] == 1) { ?>
                                    <a href="index.php?uc=validationFrais&action=suppression&id=<?php echo $unInfoHorsFrais['id'] ?>&libelle=<?php echo $unInfoHorsFrais['libelle'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');"><img src="./images/icon-supprimer.jpg" title="Supprimer la ligne de frais" /></a>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                    <a href="index.php?uc=validationFrais&action=reportMois&id=<?php echo $unInfoHorsFrais['id'] ?>&mois=<?php echo $unInfoHorsFrais['mois'] ?>" onclick="return confirm('Voulez-vous vraiment reporter ce frais?');"><img src="./images/report-icon.png" title="reporter le frais  />"</a>
                                        <?php } ?>

                                    <a href="index.php?uc=validationFrais&action=suppression&id=<?php echo $unInfoHorsFrais['id'] ?>&libelle=<?php echo $unInfoHorsFrais['libelle'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');"><img src="./images/icon-supprimer.jpg" title="Supprimer la ligne de frais" /></a>