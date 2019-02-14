<script>
    $(document).ready(function () {
		$("#reset").click(function () {
			$("#getal").val("0");
		});
		$("#plus").click(function () {
			var getal = $("#getal").val();
			getal++;
			$("#getal").val(getal);
		});
		$("#min").click(function () {
			var getal = $("#getal").val();
			getal--;
			$("#getal").val(getal);
		});
    });
</script>

<div class="col-12 mt-3">
    <form>
        <div class="form-group">
            <?php echo form_label('Getal', 'getal'); ?>
            <?php echo form_input(array('name' => 'getal', 'id' => 'getal', 'type' => 'number', 'class' => 'form-control', 'placeholder' => 'Getal')); ?>
        </div>
        <div>
            <?php echo form_button(array("content" => "++", "class" => "btn btn-primary", "id" => "plus")); ?>
            <?php echo form_button(array("content" => "--", "class" => "btn btn-primary", "id" => "min")); ?>
			<?php echo form_button(array("content" => "Reset", "class" => "btn btn-primary", "id" => "reset")); ?>
		</div>
    </form>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
