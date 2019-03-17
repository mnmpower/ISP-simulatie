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

    $(document).ready(function () {
		$('#ButtonSubmitKlas').attr("disabled", "disabled");
        $("#klaskeuze").change(function () {
            klasId = $('#klaskeuze').val();
            if(klasId == '0') {
                $('#resultaat').html("");
				$('#ButtonSubmitKlas').attr("disabled", "disabled");
			} else {
                haalKlassenOp(klasId);
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
?>
<div class="container">
    <h1>
        <?php echo $title ?>
    </h1>
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('Student/voorkeurBevestigen', $attributes);
    $formattributes = array('id' => 'klaskeuze', 'class' => 'form-control');
    echo form_dropdown('klas', $klasOpties, '0', $formattributes);
    echo "<div id=\"resultaat\"></div>";
    $submitattributes = array('class' => 'form-control', 'id' => 'ButtonSubmitKlas' );
    echo form_submit('klasvoorkeur', 'Klasvoorkeur bevestigen', $submitattributes);
    echo form_close();
    ?>
</div>
