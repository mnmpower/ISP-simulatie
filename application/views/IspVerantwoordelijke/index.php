<?php
	/**
	 * @file index.php
	 * View waarin de ingediende ISP's van de student wordt weergegeven
	 * Krijgt een $persoonobject binnen
	 */
?>
<div class="container70"><h1>
		<?php
			echo $title
		?>
	</h1>
	<table data-toggle="table" class="table-striped table-borderless table-hover ">
		<thead>
		<tr>
			<th data-sortable="true" class="text-capitalize">Studentennummer</th>
			<th data-sortable="true" class="text-capitalize">Naam</th>
			<th data-sortable="true" class="text-capitalize">Klas</th>
			<th data-sortable="true" class="text-capitalize">Aantal studiepunten</th>
			<th data-sortable="true" class="text-capitalize">Advies</th>
			<th class="text-capitalize">Bekijk details</th>
		</tr>
		</thead>
		<tbody>

		<?php
			foreach ($ingediendeIspStudenten as $student) {
				echo "<tr><td>$student->nummer</td>";
				echo "<td>$student->naam</td>";
				echo "<td>";
				if ($student->klas!= null){
					echo $student->klas->naam;

				}
				echo "</td>";
				echo "<td>$student->studiepunten</td>";
				echo "<td>$student->advies</td>";
				echo "<td><a href='toonISPDetails/" . $student->id . "'><i class=\"far fa-eye \"></i></a></td></tr>";
			}
		?>

		</tbody>
	</table>

</div>
