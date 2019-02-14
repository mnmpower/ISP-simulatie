<script>
    function haalProductenOp(soortId) {
        //vervolledigen (oef 4 - stap 2)
        //roep functie haalAjaxOp_Producten() uit Les3-controller op
		$.ajax({
			type: "GET",
			url: site_url + "/les3/haalAjaxOp_Producten",
			data: {soortId: soortId},
			success: function (result) {
				$("#product").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});
    }

    function haalProductDetailOp(productId) {
        //vervolledigen (oef 4 - stap 3)
        //roep functie haalAjaxOp_Product() uit Les3-controller op - zie oef3b
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
    }

    $(document).ready(function() {

        $("#kaart").hide();

        $("#soort").change(function() {
            haalProductenOp($(this).val());
			$("#kaart").fadeOut();
        });

        // hier vervolledigen (oef 4 - stap 3)
        // product-change moet je zelf nog bij aanmaken
        // roep daarin methode haalProductDetailOp() op

		$("#product").change(function() {
			var id= $(this).val();
			$('#kaart').fadeOut(500, function () {
				haalProductDetailOp(id);
				$('#kaart').fadeIn(500);
			});
		});
    });

</script>


<div class="col-lg-4 mt-3">
    <p>
        <?php
            //hier aanpassen om biersoorten te tonen (oef 4  - stap 1)
            echo form_listbox_pro('soort',$soorten, 'id', 'naam', 0, array('id' => 'soort', 'size' => '10', 'class' => 'form-control'));
        ?>
    </p>
    <p>
        <?php echo form_listbox_pro('product', array(), 'id', 'naam', 0, array('id' => 'product', 'size' => '10', 'class' => 'form-control')); ?>
    </p>
</div>
<div class="col-lg-8 mt-3">
    <div class="card border-primary" id="kaart">
        <div class="card-header bg-primary text-white">Product</div>
        <div class="card-body">
            <div id="resultaat"></div>
        </div>
    </div>
</div>


<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>
