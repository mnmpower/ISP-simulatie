<?php
/**
 * @file jaarvakken_raadplegen.php
 * Pagina waarop de student de vakken per keuzerichting en fase kan opvragen
 * Gebruikt ajax-call om de vakken per fase per keuzerichting op te halen
 */
?>
<?php
    $keuzerichtingenNieuw[0] = 'Kies een keuzerichting..';
    foreach ($keuzerichtingen as $keuzerichting) {
        $keuzerichtingenNieuw[$keuzerichting->id] = $keuzerichting->naam;
    }
?>

<script>

    function haalVakkenOp(keuzerichtingId) {
        $.ajax({
            type: "GET",
            url: site_url + "/student/haalAjaxOp_Vakken/",
            data: {keuzerichtingId: keuzerichtingId},
            success: function(output) {
                $('#resultaat').html(output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $("#richting").change(function () {
            keuzerchtingId = $('#richting').val();
            if(keuzerchtingId == 0) {
                $('#resultaat').html("");
            } else {
                haalVakkenOp(keuzerchtingId);
            }
        });
    });

</script>

<div class="container">
    <h1>Vakken per fase</h1>
    <?php
        $attributes = array('name' => 'mijnFormulier');
        echo form_open('url', $attributes);
        $dropdownAttributes = array('id' => 'richting', 'class' => "form-control");
        echo form_dropdown('richting', $keuzerichtingenNieuw, '0', $dropdownAttributes);
        echo form_close();
    ?><br>
    <div id="resultaat" class="container">

    </div>
</div>