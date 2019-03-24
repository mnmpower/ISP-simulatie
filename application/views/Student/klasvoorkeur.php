<?php
/**
 * @file klasvoorkeur.php
 * View waarin de uurrooster en samenstelling van de klassen wordt weergegeven
 * krijgt een $klasobject binnen
 * gebruikt ajax-call om de uurrooster en samenstelling van de klassen op te halen
 */
?>
<script>
    function haalKlassenOp(klasId) {
        $.ajax({
            type: "GET",
            url: site_url + "/ispverantwoordelijke/haalAjaxOp_Klassen/",
            data: {klasId: klasId},
            success: function(output) {
                $('#resultaat').html(output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function haalUurroosterOp(semester) {
        $.ajax({
            type: "GET",
            url: site_url + "/student/haalAjaxOp_Uurrooster/",
            data: {semester: semester},
            success: function(output) {
                $('#uurrooster').html(output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
		$('#ButtonSubmitKlas').attr("disabled", "disabled");

        $("#klaskeuze").change(function () {
            klasId = $('#klaskeuze').val();
            semester =  $('#semesterkeuze option:selected').text();
            if(klasId == '0') {
                $('#resultaat').html("");
                $('#uurrooster').html("");
				$('#ButtonSubmitKlas').attr("disabled", "disabled");
			} else {
                haalKlassenOp(klasId);
                haalUurroosterOp(semester);
				$('#ButtonSubmitKlas').removeAttr("disabled");
            }
        });

        $("#semesterkeuze").change(function () {
            klasId = $('#klaskeuze').val();
            semester =  $('#semesterkeuze option:selected').text();
            if(klasId == '0') {
                $('#resultaat').html("");
                $('#uurrooster').html("");
                $('#ButtonSubmitKlas').attr("disabled", "disabled");
            } else {
                haalKlassenOp(klasId);
                haalUurroosterOp(semester);
                $('#ButtonSubmitKlas').removeAttr("disabled");
            }
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
<div class="container">
    <h1>
        <?php echo $title ?>
    </h1>
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('Student/voorkeurBevestigen', $attributes);
    $klasattributes = array('id' => 'klaskeuze', 'class' => 'form-control');
    echo form_dropdown('klas', $klasOpties, '0', $klasattributes);
    $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control');
    echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
    echo "<div id=\"resultaat\"></div>";
    echo "<div id=\"uurrooster\"></div>";
    $submitattributes = array('class' => 'form-control', 'id' => 'ButtonSubmitKlas' );
    echo form_submit('klasvoorkeur', 'Klasvoorkeur bevestigen', $submitattributes);
    echo form_close();
    ?>
</div>
