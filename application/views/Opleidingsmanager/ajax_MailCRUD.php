<?php
/**
 * @file ajax_MailgCRUD.php
 * Ajaxpagina waarin de CRUD voor het beheren van de mails wordt weergeven
 */
?>
<table class="table table-striped">
	<thead>
	<tr>
		<th width="80%">Onderwerp</th>
		<th width="10%"></th>
		<th width="10%"></th>
	</tr>
	</thead>
	<tablebody>
		<tr>
			<?php


				foreach ($mails as $mail) {
					$wijzigButton = array('class' => 'btn btn-success wijzig', 'data-mailid' => $mail->id, 'data-toggle' => 'tooltip',
						"title" => "Wijzig mail");
					$verwijnderButton = array('class' => 'btn btn-danger verwijder', 'data-mailid' => $mail->id, 'data-toggle' => 'tooltip',
						"title" => "Verwijder mail");
					echo "<td>$mail->onderwerp</td>";
					echo "<td>" . form_button("knopwijzig" . $mail->id, '<i class="fas fa-edit"></i> Wijzig', $wijzigButton) . "</td>";
					echo "<td>" . form_button("knopverwijder" . $mail->id, '<i class="fas fa-trash-alt"></i> Verwijder', $verwijnderButton) . "</td>";
					echo "</tr><tr>";
				}
			?>
		</tr>
	</tablebody>
</table>
