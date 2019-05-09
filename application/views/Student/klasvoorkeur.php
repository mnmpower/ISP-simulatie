<?php
	/**
	 * @file klasvoorkeur.php
	 * View waarin de uurrooster en samenstelling van de klassen wordt weergegeven
	 * Krijgt een array van $klasobjecten binnen
	 * Gebruikt ajax-call om de uurrooster en samenstelling van de klassen op te halen
	 */
?>
<script>
	function haalKlassenOp(klasId, semester) {
		$.ajax({
			type: "GET",
			url: site_url + "/Student/haalAjaxOp_Klassen/",
			data: {klasId: klasId, semester: semester},
			success: function (output) {
				$('#resultaat').html(output);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});
	}

	function haalUurroosterOp(klasId, semesterId) {
		$.ajax({
			type: "GET",
			url: site_url + "/Student/haalAjaxOp_Uurrooster/",
			data: {klasId: klasId, semesterId: semesterId},
			success: function (output) {
				$('#uurrooster').html(output);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});
	}

	$(document).ready(function () {
		$('#ButtonSubmitKlas').attr("disabled", "disabled");
        $("#klaskeuze option:first").attr('disabled', 'disabled');
		$('#semesterkeuze').hide();

		$("#klaskeuze").change(function () {
			var klasId = $('#klaskeuze').val();
			var semesterId = $('#semesterkeuze').val();
			if (klasId == '0') {
				$('#semesterkeuze').hide();
				$('#resultaat').html("");
				$('#uurrooster').html("");
				$('#ButtonSubmitKlas').attr("disabled", "disabled");
			} else {
				$('#semesterkeuze').show();
				haalKlassenOp(klasId);
				haalUurroosterOp(klasId, semesterId);
				$('#ButtonSubmitKlas').removeAttr("disabled");
			}
		});

		$("#semesterkeuze").change(function () {
			var klasId = $('#klaskeuze').val();
			var semesterId = $('#semesterkeuze').val();
			haalUurroosterOp(klasId, semesterId);
		});
	});

</script>
<?php

	$klasOpties = array();
	$klasOpties[0] = 'Kies een klas..';

	foreach ($klassen as $klasOptie) {
		$klasOpties[$klasOptie->id] = $klasOptie->naam;
	}

	$semesterOpties = array('Semester 1', 'Semester 2');
?>
<div class="container70">
    <div class="row">
        <h1 class="col-sm">Klasvoorkeur doorgeven</h1>
        <?php $backButtonAttributes = array('class' => 'backButton col-sm');
        echo form_open_multipart("student/setType", $backButtonAttributes); ?>
        <button class="form-control btn-primary text-white btn">
            <i class="fas fa-chevron-left"></i> Terug naar menu
        </button>
        <?php echo form_close(); ?>
    </div>
	<?php
		$attributes = array('name' => 'mijnFormulier');
		echo form_open('Student/voorkeurBevestigen', $attributes);

		$klasattributes = array(
			'id' => 'klaskeuze',
			'class' => 'form-control mt-4 mb-3'
		);
		echo form_dropdown('klas', $klasOpties, '0', $klasattributes);



		$semesterattributes = array(
			'id' => 'semesterkeuze',
			'class' => 'form-control mt-4 mb-3'
		);
		echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);


		$submitattributes = array(
			'class' => 'form-control btn-primary btn menuButton',
			'id' => 'ButtonSubmitKlas'
		);
		echo form_submit('klasvoorkeur', 'Klasvoorkeur bevestigen', $submitattributes);


		echo "<div class='row'><div id=\"uurrooster\" class='mt-4 mb-3 col-sm-12 col-md-9'></div>";
		echo "<div id=\"resultaat\"  class='col-sm-12 col-md-3' style=' margin-top: 15px'></div></div>";

		echo form_close();
	?>
</div>
