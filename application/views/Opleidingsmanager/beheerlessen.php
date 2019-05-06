<?php
/**
 * @file beheerlessen.php
 * View waarin de admin aan de hand van een CRUD de lessen kan wijzigen
 */
    $klassenList = Array("" => "-- Kies een klas --");
    foreach ($klassen as $klas) {
        $klassenList[$klas->id] = $klas->naam;
    }
    ksort($klassenList);

    $vakkenList = Array("" => "-- Kies een vak --");
    foreach ($vakken as $vak) {
        $vakkenList[$vak->id] = $vak->naam;
    }
    ksort($vakkenList);

    $dagenList = Array("" => "-- Kies een dag --", 1 => "Maandag", 2 => "Dinsdag", 3 => "Woensdag", 4 => "Donderdag", 5 => "Vrijdag");
?>
<script>
    function haalLessenOp() {
        $.ajax({
            type: "GET",
            url: site_url + "/Opleidingsmanager/haalAjaxOp_Lessen",
            success: function (result) {
                $("#lijst").html(result);
                $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren op dynamisch (mbv AJAX) gegenereerde content
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalLessenOp) --\n\n" + xhr.responseText);
            }
        });
    }

    function haalLesOp(lesId) {
        $.ajax({
            type: "GET",
            url: site_url + "/Opleidingsmanager/haalJsonOp_Les",
            data: {lesId: lesId},
            success: function (les) {
                $("#lesId").val(les.id);
                $("#lesVak").val(les.vak.id);
                $("#lesKlas").val(les.klas.id);
                $("#lesDag").val(les.dag);
                $("#lesStartuur").val(les.startuur);
                $("#lesEinduur").val(les.einduur);

                $("#knop").val("Wijzigen");
                $("#actie").text("wijzigen");
                $('#modalInvoer').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalLesOp) --\n\n" + xhr.responseText);
            }
        });
    }

    function controleerLesEnVraagBevestiging(lesId) {
        $.ajax({
            type: "GET",
            url: site_url + "/Opleidingsmanager/haalJsonOp_Les",
            data: {lesId: lesId},
            success: function (les) {
                $("#boodschap").html("<p>Bent u zeker dat u de les <b>" + les.vak.naam + " (" + les.klas.naam + ")</b> wil verwijderen?</p><p><b>Let op!</b> Als u deze les verwijderd wordt deze ook uit de ISP-simulatie van de personen die dit vak ingepland hebben verwijderd!");
                $("#lesIdBevestiging").val(lesId);

                $('#modalBevestiging').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (controleerLesEnVraagBevestiging) --\n\n" + xhr.responseText);
            }
        });
    }

    function schrapLes(lesId) {
        $.ajax({
            type: "GET",
            url: site_url + "/Opleidingsmanager/schrapAjax_Les",
            data: {lesId: lesId},
            success: function (result) {
                $('#modalBevestiging').modal('hide');
                haalLessenOp();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (schrapLes) --\n\n" + xhr.responseText);
            }
        });
    }

    function controleerFoutmelding() {
        var foutmelding = "<?php echo $foutmelding; ?>";

        if (foutmelding.indexOf("van") >= 0) {
            $('#modalUploadVoltooid').modal('show');
            $('#aantalExcel').text(foutmelding.replace('%20', ' ').replace('%20', ' ').replace('%20', ' '));
        } else if(foutmelding != "") {
            $('#modalExcel').modal('show');
            $("#excelFile").addClass("is-invalid");
        }
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren

        haalLessenOp();
        controleerFoutmelding();

        $("#voegtoe").click(function () {
            $("#lesId").val(0);
            $("#lesVak").val("");
            $("#lesKlas").val("");
            $("#lesDag").val("");
            $("#lesStartuur").val("");
            $("#lesEinduur").val("");

            $("#knop").val("Toevoegen");
            $("#actie").text("toevoegen");
            $('#modalInvoer').modal('show');
        });

        $("#lijst").on('click', ".wijzig", function () {
            var lesId = $(this).data('lesid');
            haalLesOp(lesId);
        });

        $("#lijst").on('click', ".schrap", function () {
            var lesId = $(this).data('lesid');
            controleerLesEnVraagBevestiging(lesId);
        });

        $("#knopJa").on('click', function () {
            var lesId = $('#lesIdBevestiging').val();
            schrapLes(lesId);
        });

        $("#knop").on('click', function (e) {
            $("#formInvoer").checkValidity();
        });

        $("#voegexceltoe").click(function () {
            $("#excelFile").val("");

            $('#modalExcel').modal('show');
        });

        $("#knopExcel").on('click', function (e) {
            $("#formExcel").checkValidity();
            if($("#excelFile").val() == null || $("#lesTypeExcel").val() == "") {
                e.preventDefault();
            }
        });
    });
</script>
<div class="container70">
    <h1><?php echo $title; ?></h1>
    <?php
        $knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Les toevoegen");
        echo "<p>" . form_button('lesnieuw', "<i class='fas fa-plus'></i> Voeg toe", $knop);
        $knopExcel = array("class" => "btn btn-warning text-white", "id" => "voegexceltoe", "data-toggle" => "tooltip", "title" => "Meerdere lessen toevoegen uit Excel-file");
        echo form_button('lessennieuw', "<i class='fas fa-file-import'></i> Excel uploaden", $knopExcel) . "</p>";
    ?>
    <div id="lijst"></div>
</div>

<!-- Invoervenster -->
<div class="modal fade" id="modalInvoer" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud invoervenster-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Les <span id="actie"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
                $attributenFormulier = array('id' => 'formInvoer');
                echo form_open('Opleidingsmanager/voegLesToe', $attributenFormulier);
            ?>
            <div class="modal-body">
                <input type="hidden" name="lesId" id="lesId">
                <table class="table table-hover table-borderless">
                    <tr>
                        <td><?php echo form_label("Vak:", "lesVak"); ?></td>
                        <td><?php echo form_dropdown('lesVak', $vakkenList, "", array('id' => 'lesVak',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label("Klas:", "lesKlas"); ?></td>
                        <td><?php echo form_dropdown('lesKlas', $klassenList, "", array('id' => 'lesKlas',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label("Weekdag:", "lesDag"); ?></td>
                        <td><?php echo form_dropdown('lesDag', $dagenList, "", array('id' => 'lesDag',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label("Startuur:", "lesStartuur"); ?></td>
                        <td><?php echo form_input(array('type' => 'time',
                                'name' => 'lesStartuur',
                                'id' => 'lesStartuur',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label("Einduur:", "lesEinduur"); ?></td>
                        <td><?php echo form_input(array('type' => 'time',
                                'name' => 'lesEinduur',
                                'id' => 'lesEinduur',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <?php
                    $annuleerButton = array('class' => 'btn btn-secundary annuleren', 'data-dismiss' => 'modal');
                    echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
                    $opslaanButton = array('class' => 'btn btn-primary opslaan', 'id' => 'knop');
                    echo form_submit("knopOpslaan", '', $opslaanButton);
                ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal dialog Bevestiging -->
<div class="modal fade" id="modalBevestiging" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bevestig!</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="lesIdBevestiging">
                <div id="boodschap"></div>
            </div>
            <div class="modal-footer">
                <?php echo form_button(array('content' => "Ja", 'id' => 'knopJa', 'class' => 'btn btn-danger')); ?>
                <?php echo form_button(array('content' => "Nee", 'id' => 'knopNee', 'class' => 'btn', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
    </div>
</div>

<!-- Invoervenster Excel -->
<div class="modal fade" id="modalExcel" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud invoervenster-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lessen toevoegen vanuit Excel</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
            echo form_open_multipart('Opleidingsmanager/uploadLessenExcel', array('id' => 'formExcel'));
            ?>
            <div class="modal-body">
                <table class="table table-hover table-borderless">
                    <tr>
                        <td><?php echo form_label("Excel-file:", "excelFile"); ?></td>
                        <td><?php echo form_upload(array('name' => 'excelFile',
                                'id' => 'excelFile',
                                'class' => 'form-control',
                                'required' => 'required',
                                'accept' => ".xlsx,.xls"
                            )); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo form_checkbox('deleteLessenExcel', true, false, array('id' => 'deleteLessenExcel'
                            )); ?>
                            <?php echo form_label("Verwijder alle lessen", "deleteLessenExcel"); ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <?php
                $annuleerButton = array('class' => 'btn btn-secundary annuleren', 'data-dismiss' => 'modal');
                echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
                $opslaanButton = array('class' => 'btn btn-primary opslaan', 'id' => 'knopExcel');
                echo form_submit("knopOpslaan", ' Uploaden', $opslaanButton);
                ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal dialog upload voltooid -->
<div class="modal fade" id="modalUploadVoltooid" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lessen toegevoegd</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p>Er zijn <span id="aantalExcel"></span> lessen succesvol toegevoegd.</p>
                <p>Zijn niet alle lessen toegevoegd? Controlleer of de vakken al in ons systeem staan.</p>
            </div>
            <div class="modal-footer">
                <?php echo form_button(array('content' => "Sluiten", 'id' => 'knopNee', 'class' => 'btn', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
    </div>
</div>