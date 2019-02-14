<script>
    $(document).ready(function () {
        $("#resultaatZone").hide();

        $("#kwadraat").click(function () {
            var getal = $("#getal").val();
            var kwadraat = getal * getal;
            var resultaat = "Het kwadraat van " + getal + " is " + kwadraat;

            $("#resultaat").html(resultaat);
            $("#resultaatZone").show();
        });
    });
</script>

<div class="col-12 mt-3">
    <?php echo form_open(); ?>
    <div class="form-group">
        <?php
            echo form_label('Getal:', 'getal');
            echo form_input(array('name' => 'getal',
                'type' => 'number',
                'id' => 'getal',
                'class' => 'form-control',
                'placeholder' => 'Getal'));
        ?>
    </div>
    <div>
        <?php
            echo form_button(array("content" => "Kwadraat",
                "class" => "btn btn-primary",
                "id" => "kwadraat"));
        ?>
    </div>
    <br/>
    <div id="resultaatZone" class="alert alert-success">
        <b>Tweede macht!</b>
        <div id="resultaat"></div>
    </div>
    <?php echo form_close(); ?>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>