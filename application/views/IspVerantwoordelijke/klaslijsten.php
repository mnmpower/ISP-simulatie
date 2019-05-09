<?php
/**
 * @file klaslijsten.php
 * View waarin de samenstelling van de klassen wordt weergegeven
 * Krijgt een array van $klasobjecten binnen
 * Gebruikt ajax-call om de samenstelling van de klassen op te halen
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
        $("#klaskeuze option:first").attr('disabled', 'disabled');
        $("#klaskeuze").change(function () {
            var klasId = $('#klaskeuze').val();
            if(klasId == '') {
                $('#resultaat').html("");
            } else {
                haalKlassenOp(klasId);
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
<div class="container70">
    <h1>
        <?php
        echo $title
        ?>
    </h1>
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('ISPVerantwoordelijke/toonKlaslijsten', $attributes);
    $formattributes = array('id' => 'klaskeuze', 'class' => 'form-control marginBottom');
    echo form_dropdown('klas', $klasOpties, '0', $formattributes);
    echo form_close();
    ?>

    <div id="resultaat"></div>
</div>

