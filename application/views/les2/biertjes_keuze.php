<script>
	function validateCheckboxes() {
		var n = $("input:checked").length;
		if(n < 3) {
			return false;
		} else {
			return true;
		}
	}

	function CheckOrUncheckAll(checkbox) {
		if (checkbox){
			$("input:checkbox").prop("checked", true);
		} else {
			$("input:checkbox").prop("checked", false);
		}
	}

    $(document).ready(function () {
        $("#foutZone").hide();

        $("#alles").click(function () {
        	var checked = document.getElementById("alles").checked;
			CheckOrUncheckAll(checked);
		});


//beide code's werken!!!! gebruik deze voor gewone button

		$("#bestel").click(function () {
			var doorgaan = validateCheckboxes();
			if (!doorgaan){
				$("#foutZone").show();
			} else {
				$("#mijnFormulier").submit();
			}
		});

//beide code's werken!!!! gebruik deze voor submit button

		// $("form").submit(function (e) {
		// 	var doorgaan = validateCheckboxes();
		// 	if (!doorgaan){
		// 		e.preventDefault();
		// 		$("#foutZone").show();
		// 	}
		// });

    });
</script>

<div class="col-12 mt-3">
    <?php
        $attributes = array('name' => 'mijnFormulier', 'id' => 'mijnFormulier', 'role' => 'form');
        echo form_open('les2/behandelBestelling', $attributes);

        echo form_checkbox(array("id" => "alles")) . "Alles selecteren";

        echo "<hr />";

        foreach ($producten as $product) {
            ?>

            <div class="form-group my-1">
                <?php echo form_checkbox(array("name" => "biertjes[]", "value" => $product->id)); ?>
                <?php echo $product->naam; ?>
            </div>
            <?php
        }

        echo form_button(array("content" => "Bestellen", "class" => "btn btn-primary my-3", "id" => "bestel"));
        echo form_close();
    ?>

    <div class=" alert alert-danger" id="foutZone">
        <b>Fout!</b> Selecteer minstens drie biertjes!
    </div>
</div>


<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
