<?php
/**
 * @file klasvoorkeur.php
 * View waarin de uurrooster en samenstelling van de klassen wordt weergegeven
 * Krijgt een $klasobject binnen
 * Gebruikt ajax-call om de uurrooster en samenstelling van de klassen op te halen
 */
?>
<script>
    function haalKlassenOp(klasId, semester) {
        $.ajax({
            type: "GET",
            url: site_url + "/IspVerantwoordelijke/haalAjaxOp_Klassen/",
            data: {klasId: klasId, semester: semester},
            success: function(output) {
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
        $('#semesterkeuze').hide();

        $("#klaskeuze").change(function () {
            var klasId = $('#klaskeuze').val();
            var semesterId = $('#semesterkeuze').val();
            if(klasId == '0') {
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
<div class="container">
    <h1>
        <?php echo $title ?>
    </h1>
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('Student/voorkeurBevestigen', $attributes);
    $klasattributes = array('id' => 'klaskeuze', 'class' => 'form-control');
    echo form_dropdown('klas', $klasOpties, '0', $klasattributes);
    echo "<div id=\"resultaat\"></div>";
    $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control');
    echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
    echo "<div id=\"uurrooster\"></div>";
    $submitattributes = array('class' => 'form-control', 'id' => 'ButtonSubmitKlas' );
    echo form_submit('klasvoorkeur', 'Klasvoorkeur bevestigen', $submitattributes);
    echo form_close();
    ?>
</div>
