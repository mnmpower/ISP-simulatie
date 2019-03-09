<script>

    function haalKlassenOp(klasId) {
        $.ajax({
            type: "GET",
            url: site_url + "/docent/haalAjaxOp_Klassen/",
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
        $("#klaskeuze").change(function () {
            klasId = $('#klaskeuze').val();
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
$klasOpties[0] = '-- Select --';

foreach ($klassen as $klasOptie) {
    $klasOpties[$klasOptie->id] = $klasOptie->naam;
}
?>
<h1>
    <?php
    echo $title
    ?>
</h1>
<?php
$attributes = array('name' => 'mijnFormulier');
echo form_open('Student/voorkeurBevestigen', $attributes);
$formattributes = array('id' => 'klaskeuze', 'class' => 'form-control');
echo form_dropdown('klas', $klasOpties, '0', $formattributes);
echo "<div id=\"resultaat\"></div>";
$submitattributes = array('class' => 'form-control');
echo form_submit('klasvoorkeur', 'Klasvoorkeur bevestigen', $submitattributes);
echo form_close();
?>