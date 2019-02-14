<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        $("#resultaatZone").hide();-->
<!--        $("#tafels").click(function () {-->
<!--			var getal = $("#getal").val();-->
<!---->
<!--			var resultaat = "";-->
<!--			var i;-->
<!--			for (i=1; i<=10; i++) {-->
<!--				var berekening = i*getal;-->
<!--				var regel = i + " * " + getal +" = " +  berekening+"<br>";-->
<!--				resultaat+= regel;-->
<!--			}-->
<!--			$("#resultaat").html(resultaat);-->
<!--			$("#resultaatZone").show();-->
<!--		})-->
<!--    });-->
<!---->
<!--</script>-->

<script>
	$(document).ready(function() {
		$("#resultaatZone").hide();
		$("#tafels").click(function () {
			var getal = $("#getal").val();
			var resultaat = "";
			if (getal == ""){
				getal = ".";
			}

			if (isNaN(getal)) {
				resultaat = "Geef een nummer in!";
				$("#resultaatZone").removeClass();
				$("#resultaatZone").addClass("alert alert-info mt-3")
			} else if (getal < 0) {
				resultaat = "Geef een positief getal in!";
				$("#resultaatZone").removeClass();
				$("#resultaatZone").addClass("alert alert-warning mt-3")
			} else {
				var i;
				for (i=1; i<=10; i++) {
					var berekening = i*getal;
					var regel = i + " * " + getal +" = " +  berekening+"<br>";
					resultaat+= regel;
				}
				$("#resultaatZone").removeClass();
				$("#resultaatZone").addClass("alert alert-success mt-3");
			}
			$("#resultaat").html(resultaat);
			$("#resultaatZone").show();
		})
	});

</script>
<?php
	echo haalJavascriptOp("bs_validator.js");
	$attributenFormulier = array('id' => 'mijnFormulier2', 'novalidate' => 'novalidate', 'class' => 'needs-validation');
	echo form_open('les1/behandelValidatie', $attributenFormulier);
?>

<div class="col-12 mt-3">

       <div class="form-group">
		   <div>
            	<?php echo form_label('Getal', 'getal'); ?>
            	<?php echo form_input(array('name' => 'getal', 'id' => 'getal', 'class' => 'form-control', 'placeholder' => 'Getal', 'min' => '0')); ?>
       		</div>
        	<div class="mt-3">
            	<?php echo form_button(array("content" => "Bereken tafel van vermenigvuldiging", "class" => "btn btn-primary", "id" => "tafels")); ?>
        	</div>
		   <div class="invalid-feedback">Vul dit veld in</div>
	    </div>
	<?php echo form_close(); ?>

    <div id="resultaatZone" class="">
        <div id="titel"><b>Tafels!</b></div>
        <div id="resultaat"></div>
    </div>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
