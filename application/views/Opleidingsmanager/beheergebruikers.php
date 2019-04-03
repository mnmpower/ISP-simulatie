<?php
/**
 * @file beheergebruikers.php
 * View waarin de admin aan de hand van een CRUD de gebruikers kan wijzigen
 */
    $types = Array(0 => "-- Kies een type --");
    foreach ($persoonTypes as $persoonType) {
        $types[$persoonType->id] = $persoonType->soort;
    }
    ksort($types);
?>
<script>
    function haalGebruikersOp() {
        $.ajax({
            type: "GET",
            url: site_url + "/opleidingsmanager/haalAjaxOp_Gebruikers",
            success: function (result) {
                $("#lijst").html(result);
                $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren op dynamisch (mbv AJAX) gegenereerde content
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalGebruikersOp) --\n\n" + xhr.responseText);
            }
        });
    }

    function haalGebruikerOp(gebruikerId) {
        $.ajax({
            type: "GET",
            url: site_url + "/opleidingsmanager/haalJsonOp_Gebruiker",
            data: {gebruikerId: gebruikerId},
            success: function (gebruiker) {
                $("#gebruikerId").val(gebruiker.id);
                $("#gebruikerNaam").val(gebruiker.naam);
                $("#gebruikerNummer").val(gebruiker.nummer);
                $("#gebruikerType").val(gebruiker.typeId);
                //resetValidatie();

                $("#knop").val("Wijzigen");
                $("#actie").text("wijzigen");
                $('#modalInvoer').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalGebruikerOp) --\n\n" + xhr.responseText);
            }
        });
    }

    function controleerGebruikerEnVraagBevestiging(gebruikerId) {
        $.ajax({
            type: "GET",
            url: site_url + "/opleidingsmanager/haalJsonOp_Gebruiker",
            data: {gebruikerId: gebruikerId},
            success: function (gebruiker) {
                $("#boodschap").html("<p>Bent u zeker dat u de gebruiker <b>" + gebruiker.naam + "</b> wil verwijderen?</p>");
                $("#gebruikerIdBevestiging").val(gebruikerId);

                $('#modalBevestiging').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (controleerGebruikerEnVraagBevestiging) --\n\n" + xhr.responseText);
            }
        });
    }

    function schrapGebruiker(gebruikerId) {
        $.ajax({
            type: "GET",
            url: site_url + "/opleidingsmanager/schrapAjax_Gebruiker",
            data: {gebruikerId: gebruikerId},
            success: function (result) {
                $('#modalBevestiging').modal('hide');
                haalGebruikersOp();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (schrapGebruiker) --\n\n" + xhr.responseText);
            }
        });
    }

    function schrijfGebruikerWeg() {
        var dataString = $("#formInvoer").serialize();

        $.ajax({
            type: "POST",
            url: site_url + "/opleidingsmanager/schrijfAjax_Gebruiker",
            data: dataString,
            success: function (result) {
                $('#modalInvoer').modal('hide');
                haalGebruikersOp();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (schrijfGebruikerWeg) --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren

        haalGebruikersOp();

        $("#voegtoe").click(function () {
            $("#gebruikerId").val("0");
            $("#gebruikerNaam").val("");
            $("#gebruikerNummer").val("");
            $("#gebruikerType").val(0);
            //resetValidatie();

            $("#knop").val("Toevoegen");
            $("#actie").text("toevoegen");
            $('#modalInvoer').modal('show');
        });

        $("#lijst").on('click', ".wijzig", function () {
            var gebruikerId = $(this).data('gebruikerid');
            haalGebruikerOp(gebruikerId);
        });

        $("#lijst").on('click', ".schrap", function () {
            var gebruikerId = $(this).data('gebruikerid');
            controleerGebruikerEnVraagBevestiging(gebruikerId);
        });

        $("#knopJa").on('click', function () {
            var gebruikerId = $('#gebruikerIdBevestiging').val();
            schrapGebruiker(gebruikerId);
        });

        $("#knop").on('click', function () {
            schrijfGebruikerWeg();
        });
    });
</script>
<div class="container70">
    <h1><?php echo $title; ?></h1>
    <?php
        $knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Gebruiker toevoegen");
        echo "<p>" . form_button('gebruikernieuw', "<i class='fas fa-plus'></i> Voeg toe", $knop);
        $knopExcel = array("class" => "btn btn-warning text-white", "id" => "voegexceltoe", "data-toggle" => "tooltip", "title" => "Meerdere gebruikers toevoegen uit Excel-file");
        echo form_button('gebruikersnieuw', "<i class='fas fa-file-import'></i> Excel uploaden", $knopExcel) . "</p>";
    ?>
    <div id="lijst"></div>
</div>

<!-- Invoervenster -->
<div class="modal fade" id="modalInvoer" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud invoervenster-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gebruiker <span id="actie"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
                $attributenFormulier = array('id' => 'formInvoer');
                echo form_open('', $attributenFormulier);
            ?>
            <div class="modal-body">
                <input type="hidden" name="gebruikerId" id="gebruikerId">
                <table class="table table-hover table-borderless">
                    <tr>
                        <td><?php echo form_label("Naam:", "gebruikerNaam"); ?></td>
                        <td><?php echo form_input(array('name' => 'gebruikerNaam',
                                'id' => 'gebruikerNaam',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label("Nummer:", "gebruikerNummer"); ?></td>
                        <td><?php echo form_input(array('name' => 'gebruikerNummer',
                                'id' => 'gebruikerNummer',
                                'class' => 'form-control',
                                'required' => 'required'
                            )); ?></td>
                    </tr>

                    <tr>
                        <td><?php echo form_label("Type:", "gebruikerNummer"); ?></td>
                        <td><?php echo form_dropdown('gebruikerType', $types, 0, array('id' => 'gebruikerType',
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
                <input type="hidden" id="gebruikerIdBevestiging">
                <div id="boodschap"></div>
            </div>
            <div class="modal-footer">
                <?php echo form_button(array('content' => "Ja", 'id' => 'knopJa', 'class' => 'btn btn-danger')); ?>
                <?php echo form_button(array('content' => "Nee", 'id' => 'knopNee', 'class' => 'btn', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
    </div>
</div>