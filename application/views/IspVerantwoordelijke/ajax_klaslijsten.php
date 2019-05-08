<?php
/**
 * @file ajax_klaslijsten.php
 * Ajaxpagina waarin de leerlingen van de geselecteerde klas wordt weergegeven
 * Krijgt een $klasobject binnen
 */
?>
<script>
    function wijzigKlas(persoonId, klasId) {
        $.ajax({
            type: "GET",
            url: site_url + "/IspVerantwoordelijke/haalAjaxOp_WijzigKlas/",
            data: {persoonId : persoonId, klasId : klasId},
            success: function (output) {
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        var id;

        $('.openModal').click(function () {
            id = $(this).data('id');
            var naam = $(this).data('persoon');
            $("#exampleModalLongTitle").html("Klas wijzigen: " + naam);
        });

        $('#klaswijzig').click(function () {
            var persoonId = id;
            var klasId = $("#klaskeuze2").val();
            klasId++;
            wijzigKlas(persoonId, klasId);
            location.reload();
        });
    });
</script>
<?php
    echo "<p>Aantal vrije plaatsen: " . ($klas->maximumAantalModel - count($personen)) . " van de " . $klas->maximumAantalModel . "</p>";
    if (count($personen) != 0){
        echo "<p>Studenten die reeds in de klasgroep zitten:</p>";
        echo "<ul>";
        foreach ($personen as $persoon){
            echo "<li><a class='openModal' href=\"#klaswijzigen\" data-toggle=\"modal\" data-target=\"#klaswijzigen\" data-id=\"" . $persoon->id  . "\" data-persoon=\"" . $persoon->naam  . "\">" . $persoon->naam . "</a></li>";
        }
    }
    echo "</ul>";
?>
<div class="modal fade" id="klaswijzigen" tabindex="-1" role="dialog" aria-labelledby="klaswijzigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open();
                    $dropdownattributes = array('id' => 'klaskeuze2', 'class' => 'form-control');
                    echo form_dropdown('klaskeuze2', $klassen, $klas->id - 1, $dropdownattributes);
                    echo form_close()
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                <button type="submit" class="btn btn-primary" id="klaswijzig" data-dismiss="modal">Bevestigen</button>
            </div>
        </div>
    </div>
</div>


