<?php
/**
 * @file mailBeheer.php
 * View waarin de admin aan de hand van een CRUD de mails kan wijzigen
 */
?>
<script>
	$(document).ready(function () {
		haalMailsOp();

		$("#voegtoe").click(function () {
			$('#modalTitle').html('Mail toevoegen');
			$("#mailOnderwerp").val("");
			$("#mailTekst").val("");
			$("#mailId").val(0);
			$('#modal').modal();
		});

		$("#MailCRUD").on('click', ".wijzig", function () {
			$('#modalTitle').html('Mail bewerken');
			var mailId = $(this).data('mailid');
			haalMailOp(mailId);
			$('#modal').modal();
		});

		$("#MailCRUD").on('click', ".verwijder", function () {
			var mailId = $(this).data('mailid');
			schrapMail(mailId);
		});
	});

	function schrapMail(mailId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/schrapAjax_Mail",
			data: {mailId: mailId},
			success: function () {
				haalMailsOp();
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (Opleidingsmanager/schrapAjax_Mail) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalMailOp(mailId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalJsonOp_Mail",
			data: {mailId: mailId},
			success: function (mail) {
				$("#mailOnderwerp").val(mail.onderwerp);
				$("#mailTekst").val(mail.tekst);
				$("#mailId").val(mail.id);

			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (haalJsonOp_Mail) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalMailsOp() {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalAjaxOp_Mails",
			success: function (result) {
				$("#MailCRUD").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (haalBrouwerijenOp) --\n\n" + xhr.responseText);
			}
		});
	}
</script>
<div class="container70 row">
	<h1 class="col-12 mt-3">
		<?php echo $title ?>
	</h1>


	<div class="col-12">
		<?php
			$knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Mail toevoegen");
			echo "<p>" . form_button('nieuweMail', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";
		?>
		<div id="MailCRUD"></div>
	</div>

	<!-- Invoervenster TOEVOEGEN-->
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog">
			<!-- Inhoud invoervenster-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Mais beheren</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<?php
					$attributenFormulier = array('id' => 'formInvoer');
					echo form_open('Opleidingsmanager/voegMailToe', $attributenFormulier);
				?>
				<div class="modal-body">
					<table class="table table-hover table-borderless table-responsive-lg">
						<tr>
							<th id="modalTitle" colspan="2">Mail toevoegen</th>
						</tr>
						<tr>
							<td><?php echo form_label("Onderwerp:", "OnderwerpLabel"); ?></td>
							<td><?php echo form_input(array('name' => 'mailOnderwerp',
									'id' => 'mailOnderwerp',
									'class' => 'form-control',
									'placeholder' => 'Onderwerp',
									'required' => 'required',
								)); ?></td>
						</tr>
						<tr>
							<td><?php echo form_label("Tekst:", "TekstLabel"); ?></td>
							<td><?php echo form_textarea(array('name' => 'mailTekst',
									'id' => 'mailTekst',
									'class' => 'form-control',
									'placeholder' => 'Schrijf hier uw mail inhoud',
									'required' => 'required',
								));
							echo form_input(array('type'=>'hidden', 'id' =>'mailId', 'name'=> 'mailId'));?>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<?php
						$annuleerButton = array('class' => 'btn btn-secundary annuleren mr-3',  'data-toggle' => 'tooltip',
							"title" => "Mail annuleren", 'id' => 'annuleernPopUp', 'data-dismiss' => 'modal');
						echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
						$opslaanButton = array('class' => 'btn btn-primary opslaan ',  'data-toggle' => 'tooltip',
							"title" => "Mail opslaan");
						echo form_submit("knopOpslaan", ' Opslaan', $opslaanButton);
					?>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>


</div>
