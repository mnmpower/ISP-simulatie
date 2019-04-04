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

        function schrapVak(vakId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/schrapAjax_Vak",
                data: {vakId: vakId},
                success: function () {
                    haalVakkenOp();
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX (Opleidingsmanager/schrapAjax_Mail) --\n\n" + xhr.responseText);
                }
            });
        }

        function haalVakOp(vakId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/haalJsonOp_Vak",
                data: {vakId: vakId},
                success: function (vak) {
                    $("#vakNaam").val(vak.naam);
                    $("#vakStudiepunten").val(vak.studiepunt);
                    $("#keuzerichtingkeuze2").val(vak.keuzerichting);
                    $("#fasekeuze2").val(vak.fase);
                    $("#semesterkeuze").val(vak.semester);
                    $("#vakOpmerking").val(vak.volgtijdelijkheidInfo);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX (haalJsonOp_Vak) --\n\n" + xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            $("#keuzerichtingkeuze").change(function () {
                var keuzerichtingId = $('#keuzerichtingkeuze').val();
                var faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });

            $("#fasekeuze").change(function () {
                var keuzerichtingId = $('#keuzerichtingkeuze').val();
                var faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });

            $("#voegtoe").click(function () {
                $('#modalTitle').html('Vak toevoegen');
                $("#vakNaam").val("");
                $("#vakStudiepunten").val(0);
                for () 
                $(".keuzerichtingcheckbox[]").checked = false;
                $("#fasekeuze2").val(0);
                $("#semesterkeuze").val(0);
                $("#vakOpmerking").val("");
                $('#modal').modal();
            });

            $("#opslaanPopUp").click(function (e) {
                e.preventDefault();
                var semesterId = $('#semesterkeuze').val();
                var faseId = $('#fasekeuze2').val();
                var keuzerichtingId = $('#keuzerichtingkeuze2').val();
                if(semesterId != '0' && faseId != '0' && keuzerichtingId != '0') {
                    $('#formInvoer').submit();
                }
            });

            $("#resultaat").on('click', ".wijzig", function () {
                $('#modalTitle').html('Vak bewerken');
                var vakId = $(this).data('vakid');
                haalVakOp(vakId);
                $('#modal').modal();
            });

            $("#resultaat").on('click', ".verwijder", function () {
                var vakId = $(this).data('vakid');
                schrapVak(vakId);
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
$semesterOpties = array('Kies een semester..', 'Semester 1', 'Semester 2');
?>
<div class="container70 row">
    <h1 class="col-12 mt-3"><?php echo $title ?></h1>
    <div class="col-12">
        <?php
            $knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Mail toevoegen");
            echo "<p>" . form_button('nieuweMail', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";
            $keuzerichtingattributes = array('id' => 'keuzerichtingkeuze', 'class' => 'form-control');
            echo form_dropdown('keuzerichting', $keuzerichtingOpties, '0', $keuzerichtingattributes);
            $faseattributes = array('id' => 'fasekeuze', 'class' => 'form-control');
            echo form_dropdown('fase', $faseOpties, '0', $faseattributes);
        ?>
        <div id="resultaat"></div>
    </div>

    <!-- Invoervenster TOEVOEGEN-->
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Inhoud invoervenster-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vakken beheren</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php
                $attributenFormulier = array('id' => 'formInvoer');
                echo form_open('Opleidingsmanager/voegVakToe', $attributenFormulier);
                ?>
                <div class="modal-body">
                    <table class="table table-hover table-borderless table-responsive-lg">
                        <tr>
                            <th id="modalTitle" colspan="2">Vak toevoegen</th>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Vak:", "VakLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_input(array('name' => 'vakNaam',
                                    'id' => 'vakNaam',
                                    'class' => 'form-control',
                                    'placeholder' => 'Naam',
                                    'required' => 'required',
                                    ));
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Studiepunten:", "StudiepuntenLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_input(array('name' => 'vakStudiepunten',
                                    'id' => 'vakStudiepunten',
                                    'class' => 'form-control',
                                    'placeholder' => 'Aan',
                                    'type' => 'number',
                                    'required' => 'required',
                                    ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Keuzerichting:", "KeuzerichtingLabel"); ?></td>
                            <td>
                                <?php
                                foreach ($keuzerichtingOpties as $keuzerichtingOptie){
                                    if ($keuzerichtingOptie != 'Kies een keuzerichting..'){
                                        $keuzerichtingattributes = array('id' => $keuzerichtingOptie);
                                        echo form_checkbox('keuzerichtingcheckbox[]', $keuzerichtingOptie, false, $keuzerichtingattributes);
                                        echo $keuzerichtingOptie;
                                        echo '<br />';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Fase:", "FaseLabel"); ?></td>
                            <td>
                                <?php
                                    $faseattributes = array('id' => 'fasekeuze2', 'class' => 'form-control');
                                    echo form_dropdown('fase2', $faseOpties, '0', $faseattributes);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Semester:", "SemesterLabel"); ?></td>
                            <td>
                                <?php
                                $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control');
                                echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Volgtijdelijkheidinfo:", "OpmerkingLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_textarea(array('name' => 'vakOpmerking',
                                    'id' => 'vakOpmerking',
                                    'class' => 'form-control',
                                    'placeholder' => 'Vul hier de volgtijdelijkheidsinfo in',
                                    ));
                                    echo form_input(array('type'=>'hidden', 'id' =>'vakId', 'name'=> 'vakId'));
                                    echo form_input(array('type'=>'hidden', 'id' =>'keuzerichtingVakId', 'name'=> 'keuzerichtingVakId'));
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <?php
                    $annuleerButton = array('class' => 'btn btn-secundary annuleren mr-3',  'data-toggle' => 'tooltip',
                        "title" => "Vak annuleren", 'id' => 'annuleernPopUp', 'data-dismiss' => 'modal');
                    echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
                    $opslaanButton = array('id' => 'opslaanPopUp', 'class' => 'btn btn-primary opslaan ',  'data-toggle' => 'tooltip',
                        "title" => "Vak opslaan");
                    echo form_submit("knopOpslaan", ' Opslaan', $opslaanButton);
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>