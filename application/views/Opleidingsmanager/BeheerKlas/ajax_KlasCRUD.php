<table class="table table-striped">
	<thead>
	<tr>
		<th width="80%">Keuzerichting Naam</th>
		<th width="10%"></th>
		<th width="10%"></th>
	</tr>
	</thead>
	<tablebody>
		<tr>
			<?php


				foreach ($klassen as $klas) {
					$wijzigButton = array('class' => 'btn btn-success wijzig', 'data-klasid' => $klas->id, 'data-toggle' => 'tooltip',
						"title" => "Wijzig Keuzerichting");
					$verwijnderButton = array('class' => 'btn btn-danger verwijder', 'data-klasid' => $klas->id, 'data-toggle' => 'tooltip',
						"title" => "Verwijder Keuzerichting");
					echo "<td>$klas->naam</td>";
					echo "<td>" . form_button("knopwijzig" . $klas->id, '<i class="fas fa-edit"></i> Wijzig', $wijzigButton) . "</td>";
					echo "<td>" . form_button("knopverwijder" . $klas->id, '<i class="fas fa-trash-alt"></i> Verwijder', $verwijnderButton) . "</td>";
					echo "</tr><tr>";
				}
			?>
		</tr>
	</tablebody>
</table>
