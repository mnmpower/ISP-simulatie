<?php
/**
 * @file KlasBeheer.php
 * View waarin de admin aan de hand van een CRUD de klassen kan wijzigen
 */
$keuzerichtingenDropdown = Array("" => "-- Kies een type --");
foreach ($keuzerichtingen as $keuzerichting) {
		$keuzerichtingenDropdown[$keuzerichting->id] = $keuzerichting->naam;

}
ksort($keuzerichtingenDropdown);
?>
<script>
	$(document).ready(function () {
		haalKlassenOp();

		$("#voegtoe").click(function () {
			$('#modalTitle').html('Klas toevoegen');
			$("#klasNaam").val("");
			$("#aantalLeerlingen").val(0);
			$("#aantalModel").val(0);
			$("#klasId").val(0);
			$("#keuzerichting").val("");
			$("#keuzerichtingKlasId").val(0);
			$('#modal').modal();
		});

		$("#KlasCRUD").on('click', ".wijzig", function () {
			$('#modalTitle').html('Klas bewerken');
			var klasId = $(this).data('klasid');
			haalKlasOp(klasId);
			$('#modal').modal();
		});

		$("#KlasCRUD").on('click', ".verwijder", function () {
			var klasId = $(this).data('klasid');
			schrapKlas(klasId);
		});
	});

	function schrapKlas(klasId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/schrapAjax_klas",
			data: {klasId: klasId},
			success: function () {
				haalKlassenOp();
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (FOUT IN SCHRAPFUNCTIE) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalKlasOp(klasId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalJsonOp_Klas",
			data: {klasId: klasId},
			success: function (klas) {
				$("#klasNaam").val(klas.naam);
				$("#klasId").val(klas.id);
				$("#aantalLeerlingen").val(klas.maximumAantal);
				$("#aantalModel").val(klas.maximumAantalModel);
                $("#keuzerichting").val(klas.keuzerichting.id);
                $("#keuzerichtingKlasId").val(klas.keuzerichtingKlas.keuzerichtingKlasId);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX ((FOUT IN OPHAALFUNCTIE) --\n\n" + xhr.responseText);
			}
		});
	}

	function haalKlassenOp() {
		$.ajax({
			type: "GET",
			url: site_url + "/Opleidingsmanager/haalAjaxOp_Klassen",
			success: function (result) {
				$("#KlasCRUD").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX (haalKlassenOp) --\n\n" + xhr.responseText);
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
			$knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Klas toevoegen");
			echo "<p>" . form_button('nieuweKlas', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";
		?>
		<div id="KlasCRUD"></div>
	</div>

	<!-- Invoervenster TOEVOEGEN-->
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog">
			<!-- Inhoud invoervenster-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Klas beheren</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<?php
					$attributenFormulier = array('id' => 'formInvoer');
					echo form_open('Opleidingsmanager/voegKlasToe', $attributenFormulier);
				?>
				<div class="modal-body">
					<table class="table table-hover table-borderless table-responsive-lg">
						<tr>
							<th id="modalTitle" colspan="2" >Klas toevoegen</th>
						</tr>
						<tr>
							<td><?php echo form_label("Naam:", "NaamLabel"); ?></td>
							<td><?php echo form_input(array('name' => 'klasNaam',
									'id' => 'klasNaam',
									'class' => 'form-control',
									'placeholder' => 'Vul naam in',
									'required' => 'required',
								));
							echo form_input(array('type' => 'hidden', 'id' => 'klasId', 'name' => 'klasId'));
							echo form_input(array('type' => 'hidden', 'id' => 'keuzerichtingKlasId', 'name' => 'keuzerichtingKlasId')); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo form_label("Max aantal leerlingen:", "maxAantalLabel"); ?></td>
							<td><?php echo form_input(array('name' => 'aantalLeerlingen',
									'id' => 'aantalLeerlingen',
									'class' => 'form-control',
									'placeholder' => 'Vul positief getal in',
									'required' => 'required',
									'type' => 'number'
								));
									?>
							</td>
						</tr>
						<tr>
							<td><?php echo form_label("Max aantal Modelstudenten:", "maxAantalModelLabel"); ?></td>
							<td><?php echo form_input(array('name' => 'aantalModel',
									'id' => 'aantalModel',
									'class' => 'form-control',
									'placeholder' => 'Vul positief getal in',
									'required' => 'required',
									'type' => 'number'
								));
								?>
							</td>
						</tr>
                        <tr>
                            <td><?php echo form_label("Keuzerichting:", "keuzerichting"); ?></td>
                            <td><?php echo form_dropdown('keuzerichting', $keuzerichtingenDropdown, "", array('id' => 'keuzerichting',
                                    'class' => 'form-control',
                                    'required' => 'required'
                                )); ?></td>
                        </tr>
					</table>
				</div>
				<div class="modal-footer">
					<?php
						$annuleerButton = array('class' => 'btn btn-secundary annuleren mr-3', 'data-toggle' => 'tooltip',
							"title" => "Klas annuleren", 'id' => 'annuleernPopUp', 'data-dismiss' => 'modal');
						echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
						$opslaanButton = array('class' => 'btn btn-primary opslaan ', 'data-toggle' => 'tooltip',
							"title" => "Klas opslaan");
						echo form_submit("knopOpslaan", ' Opslaan', $opslaanButton);
					?>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>


</div>
