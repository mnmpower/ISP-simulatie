<script>
    $(document).ready(function () {

        $("div.alert").click(function () {
            $(this).hide();
        });

        $("#knop").click(function () {
            $("div.alert").show();
        });
    });
</script>

<div class="col-12 mt-3">

    <div class="alert alert-success">
        <b>Succes!</b> Geeft een succesvolle of positieve actie aan.
    </div>

    <div class="alert alert-info">
        <b>Info!</b> Geeft een neutrale informatieve verandering of actie aan.
    </div>

    <div class="alert alert-warning">
        <b>Waarschuwing!</b> Geeft een waarschuwing aan die mogelijk aandacht vereist.
    </div>

    <div class="alert alert-danger">
        <b>Gevaar!</b> Geeft een gevaarlijke of potentieel negatieve actie aan.
    </div>

    <?php echo form_button(array("content" => "Toon",
        "class" => "btn btn-primary",
        "id" => "knop")); ?>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>