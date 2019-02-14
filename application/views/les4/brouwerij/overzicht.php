<script>
    //jQuery-functie die via AJAX/JSON-call controleert of de ingegeven naam al in de tabel bier_soort voorkomt.
    //Als de naam nog niet voorkomt, wordt de biersoort weggeschreven via de functie schrijfSoortWeg().
    //Als de naam wel voorkomt, wordt validatie-info toegevoegd aan het tekstvak '#naam' in het modal
    //venster '#modalInvoer'.
    //Deze functie wordt opgeroepen nadat er in het modal venster '#modalInvoer' op de knop 'Wijzigen' of 'Toevoegen'
    //is geklikt.
    function controleerDubbelEnSchrijfWegOfToonFout() {
        var isDubbel = false;

        //https://api.jquery.com/serialize/
        //https://www.w3schools.com/jquery/ajax_serialize.asp
        var dataString = $("#formInvoer").serialize(); //invoer uit formulier omzetten in juiste formaat (URL-encoded)

        $.ajax({
            type: "POST", //POST ipv GET (informatie uit formulier)
            url: site_url + "/soort/controleerJson_DubbelSoort",
            data: dataString,
            success: function (result) {
                isDubbel = result;
                if (!isDubbel) {
                    schrijfSoortWeg();
                }
                else {
                    //extra/eigen validatie op bootstrap-manier
                    $("div.invalid-feedback").html("Deze biersoort bestaat reeds!"); //validatie-boodschap aanpassen
                    $("#naam").addClass("is-invalid"); //met de klasse "is-invalid" aangeven dat validatie mislukt is
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (controleerDubbelEnSchrijfWegOfToonFout) --\n\n" + xhr.responseText);
                return true;
            }
        });
    }

    //jQuery-functie die de boodschap voor het modal venster '#modalBevestiging" opmaakt, en dit modal venster weergeeft.
    //Via een AJAX/JSON-call wordt de record met id = soortId opgehaald uit de tabel bier_soort,
    //samen met alle records uit de tabel bier_product met soortId = soortId.
    //Deze functie wordt opgeroepen nadat er in de CRUD op een knop 'Verwijder' (naast een biersoort) is geklikt.
    function controleerSoortEnVraagBevestiging(soortId) {
        $.ajax({
            type: "GET",
            url: site_url + "/soort/haalJsonOp_SoortMetProducten",
            data: {soortId: soortId},
            success: function (soort) {
                if (soort.producten.length == 0) { //er horen geen bierproducten bij deze soort
                    $("#boodschap").html("<p>Bent u zeker dat u de soort <b>" + soort.naam + "</b> wil verwijderen?</p>");
                }
                else { //er horen bierproducten bij deze soort
                    $("#boodschap").html("<p>Voor de soort <b>" + soort.naam + "</b> bestaan er nog <b>" + soort.producten.length
                        + "</b> bierproducten, namelijk:</p>");

                    var bericht = "<ul>";
                    for (var i = 0; i < soort.producten.length; i++) {
                        bericht += "<li>" + soort.producten[i].naam + "</li>\n";
                    }
                    bericht += "</ul>";
                    $("#boodschap").append(bericht);
                    $("#boodschap").append("<p>Bent u zeker dat u de soort <b>" + soort.naam + "</b> (én de bovenstaande bierproducten) toch wil verwijderen?</p>");
                }
                //soortId invullen in hidden field van modal venster '#modalBevestiging'
                //om later te kunnen "doorgeven" aan functie schrapBrouwerij()
                $("#soortIdBevestiging").val(soortId);

                $('#modalBevestiging').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (controleerSoortEnVraagBevestiging) --\n\n" + xhr.responseText);
            }
        });
    }

    //jQuery-functie die via AJAX-call alle records uit de tabel bier_soort (met een knop 'Wijzig' en 'Verwijder')
    //weergeeft in de daarvoor voorziene <div> in de CRUD.
    function haalBrouwerijenOp() {
        $.ajax({
            type: "GET",
            url: site_url + "/brouwerij/haalAjaxOp_Brouwerijen",
            success: function (result) {
                $("#lijst").html(result);
                $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren op dynamisch (mbv AJAX) gegenereerde content
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalBrouwerijenOp) --\n\n" + xhr.responseText);
            }
        });
    }

    //jQuery-functie die via AJAX/JSON-call de record met id = soortId ophaalt uit de tabel bier_soort.
    //Daarna wordt deze record weergegeven in het modal venster '#modalInvoer' (met de knop 'Wijzigen').
    //Deze functie wordt opgeroepen nadat er in de CRUD op een knop 'Wijzig' is geklikt.
    function haalBrouwerijOp(soortId) {
        $.ajax({
            type: "GET",
            url: site_url + "/brouwerij/haalJsonOp_Brouwerij",
            data: {soortId: soortId},
            success: function (soort) {
                //id van soort invullen in hidden field van modal venster '#modalInvoer'
                //om later te kunnen "doorgeven" aan functie controleerDubbelEnSchrijfWegOfToonFout()
                $("#soortIdInvoer").val(soort.id);
                $("#naam").val(soort.naam);
                resetValidatie();
                $("#knop").val("Wijzigen");  //tekst op knop aanpassen; knop is van input-type, dus met val() werken
                $('#modalInvoer').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (haalBrouwerijOp) --\n\n" + xhr.responseText);
            }
        });
    }

    //jQuery-functie die de validatie (bootstrap validatie én zelf geschreven validatie op dubbele biersoorten) reset.
    function resetValidatie() {
        //bestaande bootstrap-validatie-info verwijderen (klasse 'was-validated' geeft aan dat validatie is gebeurd)
        $("#formInvoer").removeClass("was-validated");

        $("#naam").removeClass("is-invalid"); //zelf-toegevoegde validatie-info verwijderen
        $("div.invalid-feedback").html("Vul dit veld in!"); //originele tekst terug in div.invalid-feedback plaatsen
    }

    //jQuery-functie die via AJAX-call de record met id = soortId verwijdert uit de tabel bier_soort. Ook de
    //records uit de tabel bier_product met soortId = soortId worden verwijderd.
    //Daarna wordt de aangepaste lijst biersoorten getoond via een oproep van de jQuery-functie haalBrouwerijenOp()
    //Deze functie wordt opgeroepen nadat er in het modal venster '#modalBevestiging' op 'Ja' is gedrukt.
    function schrapBrouwerij(brouwerijId) {
        $.ajax({
            type: "GET",
            url: site_url + "/brouwerij/schrapAjax_Brouwerij",
            data: {soortId: soortId},
            success: function (result) {
                $('#modalBevestiging').modal('hide');
                haalBrouwerijenOp();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (schrapBrouwerij) --\n\n" + xhr.responseText);
            }
        });
    }

    //jQuery-functie die via AJAX/JSON-call de record met id = soortId uit de tabel bier_soort
    // updatet (als soortId verschillend is van 0) of een nieuwe record toevoegt (als soortId = 0).
    //Daarna wordt de aangepaste lijst biersoorten getoond via een oproep van de jQuery-functie haalBrouwerijenOp().
    //Deze functie wordt opgeroepen vanuit de functie controleerDubbelEnSchrijfWegOfToonFout().
    function schrijfSoortWeg() {
        var dataString = $("#formInvoer").serialize(); //zie ook functie controleerDubbelEnSchrijfWegOfToonFout()

        $.ajax({
            type: "POST", //POST ipv GET (informatie uit formulier)
            url: site_url + "/soort/schrijfAjax_Soort",
            data: dataString,
            success: function (result) {
                $('#modalInvoer').modal('hide');
                haalBrouwerijenOp();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX (schrijfSoortWeg) --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip(); //bootstrap-tooltips activeren

        haalBrouwerijenOp();

        //Als men in de CRUD op de knop 'Toevoegen' klikt, wordt een "leeg" modal venster '#modalInvoer'
        //(met de knop 'Toevoegen') weergegeven
        $("#voegtoe").click(function () {
            $("#soortIdInvoer").val("0"); //id van nieuwe soort (=0) invullen in hidden field van modal venster '#modalInvoer'
            $("#naam").val(""); //invoervenster voor naam van nieuwe soort leeg maken
            resetValidatie();

            $("#knop").val("Toevoegen"); //tekst op knop aanpassen; knop is van input-type, dus met val() werken
            $('#modalInvoer').modal('show');
        });

        //Als men in de CRUD naast een biersoort op knop 'Wijzig' klikt
        //met on werken omdat lijst biersoorten dynamisch (mbv Ajax) wordt gegenereerd
        //https://1itf.gitbook.io/jquery/6-events/de-methode-on
        $("#lijst").on('click', ".wijzig", function () {
            var soortId = $(this).data('soortid');
            haalBrouwerijOp(soortId);
        });

        //Als men in de CRUD naast een biersoort op knop 'Verwijder' klikt
        //met on werken omdat lijst biersoorten dynamisch (mbv Ajax) wordt gegenereerd
        //https://1itf.gitbook.io/jquery/6-events/de-methode-on
        $("#lijst").on('click', ".schrap", function () {
            var soortId = $(this).data('soortid');
            controleerSoortEnVraagBevestiging(soortId);
        });

        //Als men op (submit-)knop (met opschrift 'Wijzigen' of 'Toevoegen') klikt in modal venster '#modalInvoer'
        $("#knop").click(function (e) {
            if ($("#formInvoer")[0].checkValidity()) { //controleer standaard bootstrap-validatie (leeg naam-veld)
                e.preventDefault(); //niet opnieuw "submitten", anders werkt serialize() later niet meer
                controleerDubbelEnSchrijfWegOfToonFout();
            }
        });

        //Als men op knop 'Ja' klikt in modal venster '#modalBevestiging'
        $("#knopJa").click(function () {
            var soortId = $("#soortIdBevestiging").val(); //soortId uit hidden field van modal venster '#modalBevestiging' halen om te kunnen doorgeven aan schrapBrouwerij()
            schrapBrouwerij(soortId);
        });

        //Als men op knop 'Nee' klikt in modal venster '#modalBevestiging'
        $("#knopNee").click(function () {
            $("#modalBevestiging").modal('hide');
            haalBrouwerijenOp();
        });

        //Validatie resetten als invoervak voor naam terug de focus krijgt
        $("#naam").focus(function () {
            resetValidatie();
        });

        //Validatie resetten als toets wordt ingedrukt in invoervak voor naam
        $("#naam").keydown(function () {
            resetValidatie();
        });
    });
</script>


<div class="col-12 mt-3">
    <?php
        $knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Biersoort toevoegen");
        echo "<p>" . form_button('soortnieuw', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";

        echo "<div id='lijst'></div>\n";
    ?>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>

<!-- Invoervenster -->
<div class="modal fade" id="modalInvoer" role="dialog">
    <div class="modal-dialog">

        <!-- Inhoud invoervenster-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Biersoort</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
                echo haalJavascriptOp("bs_validator.js"); //bootstrap-validatie
                $attributenFormulier = array('id' => 'formInvoer', 'novalidate' => 'novalidate', 'class' => 'needs-validation');
                echo form_open('', $attributenFormulier) . "\n";
            ?>
            <div class="modal-body">
                <input type="hidden" name="soortId" id="soortIdInvoer">
                <div class="form-group">
                    <?php echo form_label('Naam', 'naam'); ?>
                    <?php
                        echo form_input(array('name' => 'soortNaam',
                            'id' => 'naam',
                            'class' => 'form-control',
                            'placeholder' => 'Naam',
                            'required' => 'required',
                        ));
                    ?>
                    <div class="invalid-feedback">Vul dit veld in</div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                    //met input-type = submit werken; anders (met button) werkt validatie niet
                    //deze knop moet voor de form_close() staan!
                    echo form_submit('', '', array('id' => 'knop', 'class' => 'btn'));
                ?>
            </div>
            <?php echo form_close() . "\n"; ?>
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
                <input type="hidden" id="soortIdBevestiging">
                <div id="boodschap"></div>
            </div>
            <div class="modal-footer">
                <?php echo form_button(array('content' => "Ja", 'id' => 'knopJa', 'class' => 'btn btn-danger'));
                ?>
                <?php echo form_button(array('content' => "Nee", 'id' => 'knopNee', 'class' => 'btn'));
                ?>
            </div>
        </div>
    </div>
</div>
