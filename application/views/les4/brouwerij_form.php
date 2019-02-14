<script>

    function haalBrouwerijOp(brouwerijId) {
        $.ajax({
            type: "GET",
            url: site_url + "/les4/haalJsonOp_Brouwerij",
            data: {brouwerijId: brouwerijId},
            success: function (brouwerij) {
                $("#naam").val(brouwerij.naam);
                $("#oprichting").val(brouwerij.oprichting);
                $("#stichter").val(brouwerij.stichter);
                $("#plaats").val(brouwerij.plaats);
                $("#werknemers").val(brouwerij.werknemers);

                var opties = "";
                for (var i = 0; i < brouwerij.producten.length; i++) {
                    opties += "<option value='" + brouwerij.producten[i].id +
                        "'>" + brouwerij.producten[i].naam + "</option>";
                }
                $("#producten").html(opties);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {

        $("#knop").click(function () {
            var brouwerijId = $(this).data('brouwerij-id');
            haalBrouwerijOp(brouwerijId);
        });

    });

</script>

<div class="col-12 mt-3">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">JSON</div>
        <div class="card-body">
            <p>
            <div class="row">
                <div class="col-lg-2 mb-3">
                    <?php echo form_button('knop', 'Brouwerij',
                        array('id' => 'knop', 'data-brouwerij-id' => '6',
                            'class' => 'btn btn-primary')); ?>
                </div>
                <div class="col-lg-10">
                    <?php echo form_open('', array("id" => "mijnFormulier")) . "\n"; ?>
                    <div class="form-group">
                        <?php echo form_label('Naam:', 'naam') . "\n"; ?>
                        <?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Opgericht op:', 'oprichting') . "\n" ?>
                        <?php echo form_input(array('name' => 'oprichting', 'id' => 'oprichting', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Stichter:', 'stichter') . "\n" ?>
                        <?php echo form_input(array('name' => 'stichter', 'id' => 'stichter', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Plaats:', 'plaats') . "\n" ?>
                        <?php echo form_input(array('name' => 'plaats', 'id' => 'plaats', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Aantal werknemers:', 'werknemers') . "\n" ?>
                        <?php echo form_input(array('name' => 'werknemers', 'id' => 'werknemers', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Producten:', 'product') . "\n" ?>
                        <?php echo form_dropdown('producten', array(), '0', 'id="producten" size="10" class="form-control"'); ?>
                    </div>
                    <?php echo form_close() . "\n"; ?>
                </div>
            </div>
            </p>
        </div>
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>