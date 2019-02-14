<script>

    function haalProductOp(productId) {
        // hier vervolledigen (oef 3b)
		$.ajax({
			type: "GET",
			url: site_url + "/les3/haalAjaxOp_Product",
			data: {productId: productId},
			success: function (result) {
				$("#resultaat").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});
		$('#mijnDialoogscherm').modal('show');


	}

    $(document).ready(function () {

        $(".product").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            haalProductOp(id);
        });

    });

</script>

<div class="col-12 mt-3">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">Biertjes</div>
        <div class="card-body">
            <?php
                    foreach ($producten as $product) {
                        echo divAnchor('', $product->naam, array('class' => 'product', 'data-id' => $product->id)) . "\n";
                    }
                ?>
        </div>
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>

<!-- Dialoogvenster -->
<div class="modal fade" id="mijnDialoogscherm" role="dialog">
    <div class="modal-dialog">

        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Biertje</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="resultaat"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>
