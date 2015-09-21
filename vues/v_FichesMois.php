<div class="container">
    <br/>
	<form method="POST" action="">
	<br/><br/>
	<center><table>
	<tr>
	<th style="width:15%"><span >Mois</span></th>
	<th style="width:20%"><span >Nombres de fiches</span></th>
	<th style="width:10%"><span >Lien</span></th>
	</tr>
	// <?php
	while($avis=$res->fetch(PDO::FETCH_OBJ)) { ?>
	<tr>
	<th style="width:15%"><span ></span></th>
	<th style="width:20%"><span ></span></th>
	<th style="width:10%"><span ></span></th>
		</tr>
		<?php } ?>
	</table></center>
	<br/><br/>
</div>