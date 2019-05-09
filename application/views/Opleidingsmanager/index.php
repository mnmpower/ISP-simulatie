<?php
/**
 * @file index.php
 * View waarin de ingediende ISP's van de student wordt weergegeven
 */
?>
<div class="container70"><h1>
		<h1><i class="fas fa-list-ul"></i> Overzicht van de ingediende ISP simulaties</h1>
	</h1>
	<table data-toggle="table" class="table-striped table-borderless table-hover ">
		<thead>
		<tr>
			<th data-sortable="true" class="text-capitalize">Studentennummer</th>
			<th data-sortable="true" class="text-capitalize">Naam</th>
			<th data-sortable="true" class="text-capitalize">Klas</th>
			<th data-sortable="true" class="text-capitalize">Aantal studiepunten</th>
			<th data-sortable="true" class="">Advies</th>
		</tr>
		</thead>
		<tbody>

		<?php
			foreach ($ingediendeIspStudenten as $student) {
				echo "<tr><td>$student->nummer</td>";
				echo "<td>$student->naam</td>";
				echo "<td>";
				if ($student->klasId!= null){
					echo $student->klas->naam;
				}
				else{
					echo "Combi";
				}
				echo "</td>";
				echo "<td>$student->studiepunten</td>";
				echo "<td>$student->advies</td></tr>";
			}
		?>

		</tbody>
	</table>


</div>
