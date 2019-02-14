<script>
    function haalProductenOp(soortId) {
        $.ajax({
            type: "GET",
            url: site_url + "/les4/haalJsonOp_Producten",
            data: {
                soortId: soortId
            },
            success: function(producten) {
                $("#productvelden").html("");
                for (var i = 0; i < producten.length; i++) {
                    $("#productvelden").append("<div class='form-group'>\n" +
                        '<input type="text" id="product' +
                        producten[i].id +
                        '" name="product[]" class="form-control"/>' +
                        "</div>\n");
                    $("#product" + producten[i].id).val(producten[i].naam);
                }
            },
            error: function(xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function() {

        $("#knop").click(function() {
            var soortId = $(this).data('soort-id');
            haalProductenOp(soortId);
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
                        <?php echo form_button('knop', 'Amber',
                            array('id' => 'knop', 'data-soort-id' => '2',
                                'class' => 'btn btn-primary')) . "\n"; ?>
                    </div>
                    <div class="col-lg-10">
                        <?php echo form_open('', array("id" => "mijnFormulier")) . "\n"; ?>
                        <div id="productvelden">
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
