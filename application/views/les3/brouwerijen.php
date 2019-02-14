<script>
    function haalBrouwerijOp(brouwerijId) {
        // hier vervolledigen (oef 2b)
		$.ajax({
			type: "GET",
			url: site_url + "/les3/haalAjaxOp_Brouwerij",
			data: {brouwerijId: brouwerijId},
			success: function (result) {
				$("#resultaat").html(result);
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});
    }

    $(document).ready(function() {

        $("#brouwerijId").change(function() {
            haalBrouwerijOp($(this).val());
        });

    });

</script>


<div class="col-md-6 mt-3">
    <?php echo form_listbox_pro('brouwerijId', $brouwerijen, 'id', 'naam', 0, array('class' => "form-control", "size" => "10", "id" => "brouwerijId")); ?>
</div>
<div class="col-md-6 mt-3">
    <div id="resultaat">
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>
