<script>
    $(document).ready(function () {
        $("#knop").click(function () {
            $("div#resultaat").html("Hallo Wereld!");
        })
		$("#herstel").click(function () {
			$("div#resultaat").html("...");
		})
    });
</script>

<div class="col-12 mt-3">
    <div class="mb-3">
		<?php echo form_button(array("content" => "Hallo",
			"class" => "btn btn-primary", "id" => "knop")); ?>

		<?php echo form_button(array("content" => "reset",
			"class" => "btn btn-primary", "id" => "herstel")); ?>
	</div>
    <div class="card bg-light">
        <div class="card-body" id="resultaat">...</div>
    </div>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
