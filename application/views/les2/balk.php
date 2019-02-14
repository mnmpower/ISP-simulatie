<script>

    function berekenInhoud() {
		var basis = $("#basis").val();
		var hoogte = $("#hoogte").val();
		var diepte = $("#diepte").val();
		var resultaat ="";
		var doorgaan = true;
		doorgaan = foutencontrole();
		if (doorgaan){
			resultaat = basis*hoogte*diepte;
			$("#inhoud").val(resultaat);

		}


    }

    function isCorrectIngevuld(afstand,naam){
		var resultaat = "";
    	if (afstand == ""){
			afstand = ".";
		}

		if (isNaN(afstand, naam)) {
			resultaat = "Geef een nummer in bij de "+ naam+"!\n<br>";

		} else if (afstand < 0) {
			resultaat = "Geef een positief getal in bij de "+ naam+"!\n<br>";

		}
		return resultaat;
	}

	function foutencontrole() {
		var basis = $("#basis").val();
		var hoogte = $("#hoogte").val();
		var diepte = $("#diepte").val();
		var resultaat ="";
		var doorgaan = true;
		resultaat += isCorrectIngevuld(basis,"basis");
		resultaat += isCorrectIngevuld(hoogte,"hoogte");
		resultaat += isCorrectIngevuld(diepte,"diepte");
		if (resultaat != ""){
			$("#fout").html(resultaat);
			$("#inhoud").val("");
			$("#foutzone").show();
			doorgaan = false;
		}
		return doorgaan;
	}


    $(document).ready(function () {
        $("#foutzone").hide();

        $("#knop").click(function () {
			$("#foutzone").hide();
            berekenInhoud();
        });
    });
</script>

<div class="col-12 mt-3">
    <form>
        <div class="form-group">
            <?php echo form_label('Basis', 'basis'); ?>
            <?php echo form_input(array('name' => 'basis', 'id' => 'basis', 'class' => 'form-control', 'placeholder' => 'Basis')); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Hoogte', 'hoogte'); ?>
            <?php echo form_input(array('name' => 'hoogte', 'id' => 'hoogte', 'class' => 'form-control', 'placeholder' => 'Hoogte')); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Diepte', 'diepte'); ?>
            <?php echo form_input(array('name' => 'diepte', 'id' => 'diepte', 'class' => 'form-control', 'placeholder' => 'Diepte')); ?>
        </div>
        <div class="mb-3">
            <?php echo form_button(array("content" => "Bereken inhoud", "class" => "btn btn-primary", "id" => "knop")); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Inhoud', 'inhoud'); ?>
            <?php echo form_input(array('name' => 'inhoud', 'id' => 'inhoud', 'class' => 'form-control', 'placeholder' => 'Inhoud')); ?>
        </div>
    </form>

    <div id="foutzone" class="alert alert-danger">
        <b>Fout!</b>
        <div id="fout"></div>
    </div>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
