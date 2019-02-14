<script>
    var getal1;
    var getal2;
    var berekening;
    var totaal;

    function klickGetal(geklikteButton) {
		var display  = $("#resultaat").val();
		display += geklikteButton;
		$("#resultaat").val(display);
	}

	function onthoudGetal1() {
		getal1 =  parseInt($("#resultaat").val());
		$("#resultaat").val("");
		return getal1;
	}

	function onthoudGetal2() {
		getal2 =   parseInt($("#resultaat").val());
		$("#resultaat").val("");
		return getal2;
	}

	//-------------------------------------------------------------
	//-----------HIER ALLES PLAATSEN VAN HOOFDACTIES---------------
	//-------------------------------------------------------------
    $(document).ready(function klickNummers() {
		$(".btn-primary").click(function () {
			var geklikteButton = ($(this).val());
			klickGetal(geklikteButton);

		});

		$("#knopPlus").click(function () {
			getal1 = onthoudGetal1();
			berekening = '+';
		});

		$("#knopMin").click(function () {
			getal1 = onthoudGetal1();
			berekening = '-';
		});

		$("#knopMaal").click(function () {
			getal1 = onthoudGetal1();
			berekening = '*';
		});

		$("#knopDeel").click(function () {
			getal1 = onthoudGetal1();
			berekening = '/';
		});

		$("#knopWissen").click(function () {
			getal1 = "";
			getal2 = "";
			berekening = "";
			totaal = "";
			$("#resultaat").val("");
		});

		$("#knopIs").click(function () {
			getal2 = onthoudGetal2();

			if (berekening === '+')
			{
				totaal = getal1+getal2;
			} else if (berekening === '-')
			{
				totaal = getal1-getal2;
			} else if (berekening === '*')
			{
				totaal = getal1*getal2;
			} else if (berekening === '/')
			{
				totaal = getal1/getal2;
			}
			$("#resultaat").val(totaal);
		});
    });
</script>

<div class="col-12 mt-3">
    <table class="text-center" cellpadding="3">
        <tr>
            <td colspan="4">
                <?php
                    echo form_input(array('class' => 'form-control',
                        'id' => 'resultaat', 'size' => '1'));
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop7', 'value' => '7', 'content' => '7'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop8', 'value' => '8', 'content' => '8'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop9', 'value' => '9', 'content' => '9'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopDeel', 'value' => '/', 'content' => '/'));
                ?>
            </td>

        </tr>
        <tr>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop4', 'value' => '4', 'content' => '4'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop5', 'value' => '5', 'content' => '5'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop6', 'value' => '6', 'content' => '6'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopMaal', 'value' => '*', 'content' => '*'));
                ?>
            </td>

        </tr>
        <tr>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop1', 'value' => '1', 'content' => '1'));
                ?>
            </td>
            <td><?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop2', 'value' => '2', 'content' => '2'));
                ?>
            </td>
            <td><?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop3', 'value' => '3', 'content' => '3'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopMin', 'value' => '-', 'content' => '-'));
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopWissen', 'value' => 'C', 'content' => 'C'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-primary',
                        'style' => 'width:38px', 'id' => 'knop0', 'value' => '0', 'content' => '0'));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopIs', 'value' => '=', 'content' => '='));
                ?>
            </td>
            <td>
                <?php
                    echo form_button(array('class' => 'btn btn-outline-secondary',
                        'style' => 'width:38px', 'id' => 'knopPlus', 'value' => '+', 'content' => '+'));
                ?>
            </td>
        </tr>
    </table>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
