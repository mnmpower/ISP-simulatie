<?php
/**
 * @file vakBeheer.php
 * View waarin de vakken worden weergegeven afhankelijk van de geselecteerde keuzerichting en fase
 * Krijgt een $keuzerichtingobject binnen
 * Gebruikt ajax-call om de vakgegevens op te halen
 */
?>
    <script>
        function haalVakkenOp(keuzerichtingId, faseId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/haalAjaxOp_Vakken/",
                data: {keuzerichtingId: keuzerichtingId, faseId: faseId},
                success: function(output) {
                    $('#resultaat').html(output);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            $("#keuzerichtingkeuze").change(function () {
                keuzerichtingId = $('#keuzerichtingkeuze').val();
                faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });

            $("#fasekeuze").change(function () {
                keuzerichtingId = $('#keuzerichtingkeuze').val();
                faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });
        });

    </script>
<?php

$keuzerichtingOpties = array();
$keuzerichtingOpties[0] = 'Kies een keuzerichting..';

foreach ($keuzerichtingen as $keuzerichtingOptie) {
    $keuzerichtingOpties[$keuzerichtingOptie->id] = $keuzerichtingOptie->naam;
}

$faseOpties = array('Kies een fase..', 'Fase 1', 'Fase 2', 'Fase 3');
?>
<h1><?php echo $title ?></h1>
<?php
    $keuzerichtingattributes = array('id' => 'keuzerichtingkeuze', 'class' => 'form-control');
    echo form_dropdown('keuzerichting', $keuzerichtingOpties, '0', $keuzerichtingattributes);
    $faseattributes = array('id' => 'fasekeuze', 'class' => 'form-control');
    echo form_dropdown('fase', $faseOpties, '0', $faseattributes);
?>
<div id="resultaat"></div>
