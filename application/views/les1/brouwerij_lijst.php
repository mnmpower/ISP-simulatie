<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<div class="col-12 mt-3">
    <?php
        echo '<p>' . anchor('brouwerij/maakNieuwe', '<i class="fas fa-plus-circle text-warning"></i>', array("title"=>"Brouwerij wijzigen toevoegen")) . '</p>';
?>
	<table class="table">
		<thead>
		<tr>
			<th scope="col">Naam</th>
			<th scope="col">Plaats</th>
			<th scope="col">Opgericht op</th>
			<th scope="col"></th>
		</tr>
		</thead>
		<tbody>
		<?php
        	foreach ($brouwerijen as $brouwerij) {
          		 echo "\n<tr><td>" . $brouwerij->naam . "</td><td>" . $brouwerij->plaats . "</td>";

if (zetOmNaarDDMMYYYY($brouwerij->oprichting)!= "00/00/0000")
	echo "<td>" . zetOmNaarDDMMYYYY($brouwerij->oprichting) . "</td>";
else {
	echo "<td></td>";
}
				echo "<td>". anchor( 'brouwerij/wijzig/'.$brouwerij->id, "<i class=\"fas fa-pencil-alt text-success\" title=\"Brouwerij wijzigen\"></i>")." ". anchor('brouwerij/schrap/'.$brouwerij->id,"<i class=\"far fa-times-circle text-danger\" title=\"Brouwerij verwijderen\"></i>"). "</td></tr>\n";
        	}
    ?></tbody></table>
</div>

<div class='col-12 mt-4'> <?php echo anchor('home', 'Terug'); ?> </div>
