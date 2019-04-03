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


				foreach ($keuzerichtingen as $Keuzerichting) {
					$wijzigButton = array('class' => 'btn btn-success wijzig', 'data-keuzerichtingid' => $Keuzerichting->id, 'data-toggle' => 'tooltip',
						"title" => "Wijzig Keuzerichting");
					$verwijnderButton = array('class' => 'btn btn-danger verwijder', 'data-keuzerichtingid' => $Keuzerichting->id, 'data-toggle' => 'tooltip',
						"title" => "Verwijder Keuzerichting");
					echo "<td>$Keuzerichting->naam</td>";
					echo "<td>" . form_button("knopwijzig" . $Keuzerichting->id, '<i class="fas fa-edit"></i> Wijzig', $wijzigButton) . "</td>";
					echo "<td>" . form_button("knopverwijder" . $Keuzerichting->id, '<i class="fas fa-trash-alt"></i> Verwijder', $verwijnderButton) . "</td>";
					echo "</tr><tr>";
				}
			?>
		</tr>
	</tablebody>
</table>
