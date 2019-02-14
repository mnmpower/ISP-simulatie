<script>

    function haalProductOp(id) {
        $.ajax({
            type: "GET",
            url: site_url + "/les4/haalJsonOp_Product",
            data: {productId: id},
            success: function (product) {
                $("#naam").val(product.naam);
                $("#uitleg").val(product.uitleg);
                $("#graden").val(product.graden);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {

        $("#knop").click(function () {
            var id = $(this).data("id");
            haalProductOp(id);
        });

    });

</script>

<div class="col-12 mt-3">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">JSON</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 mb-3">
                    <?php echo form_button('knop', 'Product', array('id' => 'knop', 'data-id' => '3', 'class' => 'btn btn-primary')); ?>
                </div>
                <div class="col-lg-10">
                    <?php echo form_open('', array("id" => "mijnFormulier")) . "\n"; ?>
                    <div class="form-group">
                        <?php echo form_label('Naam:', 'naam') . "\n" ?>
                        <?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Graden:', 'graden') . "\n" ?>
                        <?php echo form_input(array('name' => 'graden', 'id' => 'graden', 'class' => "form-control")); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Uitleg:', 'uitleg') . "\n" ?>
                        <?php echo form_textarea(array('name' => 'uitleg', 'id' => 'uitleg', 'class' => "form-control")); ?>
                    </div>
                    <?php echo form_close() . "\n"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>