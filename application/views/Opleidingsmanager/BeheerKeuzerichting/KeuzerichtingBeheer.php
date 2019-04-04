<script>
	$(document).ready(function () {
		haalKeuzerichtingenOp();

		$("#voegtoe").click(function () {
			$('#modalTitle').html('Keuzerichting toevoegen');
			$("#KeuzerichtignNaam").val("");
			$("#mailId").val(0);
			$('#modal').modal();
		});

		$("#KeuzerichtingCRUD").on('click', ".wijzig", function () {
			$('#modalTitle').html('Keuzerichting bewerken');
			var keuzerichtingId = $(this).data('keuzerichtingid');
			haalKeuzerichtingOp(keuzerichtingId);
			$('#modal').modal();
		});

		$("#KeuzerichtingCRUD").on('click', ".verwijder", function () {
			var keuzerichtingId = $(this).data('keuzerichtingid');
			schrapKeuzerichting(keuzerichtingId);
		});
	});

	function schrapKeuzerichting(keuzerichtingId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/schrapAjax_Keuzerichting",
			data: {keuzerichtingId: keuzerichtingId},
			success: function () {
				haalKeuzerichtingenOp();
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (FOUT IN SCHRAPFUNCTIE) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalKeuzerichtingOp(keuzerichtingId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalJsonOp_Keuzerichting",
			data: {keuzerichtingId: keuzerichtingId},
			success: function (Keuzerichting) {
				$("#KeuzerichtignNaam").val(Keuzerichting.naam);
				$("#KeuzerichtingId").val(Keuzerichting.id);

			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX ((FOUT IN OPHAALFUNCTIE) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalKeuzerichtingenOp() {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalAjaxOp_Keuzerichtingen",
			success: function (result) {
				$("#KeuzerichtingCRUD").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (haalKeuzerichtingenOp) --\n\n" + xhr.responseText);
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
			$knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Keuzerichting toevoegen");
			echo "<p>" . form_button('nieuweMail', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";
		?>
		<div id="KeuzerichtingCRUD"></div>
	</div>

	<!-- Invoervenster TOEVOEGEN-->
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog">
			<!-- Inhoud invoervenster-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Keuzerichting beheren</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<?php
					$attributenFormulier = array('id' => 'formInvoer');
					echo form_open('Opleidingsmanager/voegKeuzerichtingToe', $attributenFormulier);
				?>
				<div class="modal-body">
					<table class="table table-hover table-borderless table-responsive-lg">
						<tr>
							<th id="modalTitle" colspan="2" >Keuzerichting toevoegen</th>
						</tr>
						<tr>
							<td><?php echo form_label("Naam:", "NaamLabel"); ?></td>
							<td><?php echo form_input(array('name' => 'KeuzerichtingNaam',
									'id' => 'KeuzerichtignNaam',
									'class' => 'form-control',
									'placeholder' => 'Vul naam in',
									'required' => 'required',
								));
							echo form_input(array('type' => 'hidden', 'id' => 'KeuzerichtingId', 'name' => 'KeuzerichtingId')); ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<?php
						$annuleerButton = array('class' => 'btn btn-secundary annuleren mr-3', 'data-toggle' => 'tooltip',
							"title" => "Keuzerichting annuleren", 'id' => 'annuleernPopUp', 'data-dismiss' => 'modal');
						echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
						$opslaanButton = array('class' => 'btn btn-primary opslaan ', 'data-toggle' => 'tooltip',
							"title" => "Keuzerichting opslaan");
						echo form_submit("knopOpslaan", ' Opslaan', $opslaanButton);
					?>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>


</div>
