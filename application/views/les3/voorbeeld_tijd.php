<script>

    function haalTijdofDatumOp(tijdOfDatum) {
        $.ajax({
            type: "GET",
            url: site_url + "/les3/haalAjaxOp_DatumTijd",
            data: {watDoen: tijdOfDatum},
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $("#tijd").click(function () {
            haalTijdofDatumOp("tijd");
        });
        $("#datum").click(function () {
            haalTijdofDatumOp("datum");
        });
    });

</script>

<div class="col-12 mt-3">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">Ajax</div>
        <div class="card-body">
            <?php
                echo form_button(array('name' => 'tijd',
                    'id' => 'tijd',
                    'content' => 'Tijd',
                    'class' => "btn btn-outline-secondary mr-2"));
                echo form_button(array('name' => 'datum',
                    'id' => 'datum',
                    'content' => 'Datum',
                    'class' => "btn btn-outline-secondary"));
            ?>
        </div>
    </div>

    <div class="mt-4" id="resultaat"></div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>



