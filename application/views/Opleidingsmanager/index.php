<div class="container70"><h1>
		<?php
			echo $title
		?>
	</h1>
	<table data-toggle="table" class="table-striped table-borderless table-hover ">
		<thead>
		<tr>
			<th data-sortable="true" class="text-uppercase">Studentennummer</th>
			<th data-sortable="true" class="text-uppercase">Naam</th>
			<th data-sortable="true" class="text-uppercase">Aantal studiepunten</th>
			<th data-sortable="true" class="text-uppercase">Advies</th>
		</tr>
		</thead>
		<tbody>

		<?php
			foreach ($ingediendeIspStudenten as $student) {
				echo "<tr><td>$student->nummer</td>";
				echo "<td>$student->naam</td>";
				echo "<td>$student->studiepunten</td>";
				echo "<td>$student->advies</td></tr>";
			}
		?>

		</tbody>
	</table>


</div>
