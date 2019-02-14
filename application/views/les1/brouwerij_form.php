<div class="col-12 mt-3">
	<?php
		echo haalJavascriptOp("bs_validator.js");
		$attributenFormulier = array('id' => 'brouwerijFormulier', 'class' => 'needs-validation', 'novalidate' => 'novalidate');
		echo form_open('brouwerij/registreer', $attributenFormulier, $brouwerij->id);
	?>

	<div class="form-group">
		<div class="form-check">
			<div><?php
				echo form_label('Naam', 'naam');
				echo form_input(array('name' => 'naam',
					'id' => 'naam',
					'value' => $brouwerij->naam,
					'class' => 'form-control',
					'placeholder' => 'Naam',
					'required' => 'required'));
			?>
			<div class="valid-feedback">OK</div>
			<div class="invalid-feedback">Vul dit veld in</div></div>
			<div><br><?php
				echo form_label('Stichter', 'stichter');
				echo form_input(array('name' => 'stichter',
					'id' => 'stichter',
					'value' => $brouwerij->stichter,
					'class' => 'form-control',
					'placeholder' => 'Stichter',
					'required' => 'required'));
			?>
			<div class="valid-feedback">OK</div>
			<div class="invalid-feedback">Vul dit veld in</div></div>
			<div><br><?php
				echo form_label('Plaats', 'plaats');
				echo form_input(array('name' => 'plaats',
					'id' => 'plaats',
					'value' => $brouwerij->plaats,
					'class' => 'form-control',
					'placeholder' => 'Plaats',
					'required' => 'required'));
			?>
			<div class="valid-feedback">OK</div>
			<div class="invalid-feedback">Vul dit veld in</div></div>
			<div><br><?php
				echo form_label('Aantal werknemers', 'werknemers');
				echo form_input(array('type' => 'number',
					'min' => '0',
					'name' => 'werknemers',
					'id' => 'werknemers',
					'value' => $brouwerij->naam,
					'class' => 'form-control',
					'placeholder' => '0',
					'required' => 'required'));
			?>
			<div class="valid-feedback">OK</div>
			<div class="invalid-feedback">Vul een positief, niet komma getal in</div></div>
			<div><br><?php
				echo form_label('Opgericht op (dd/mm/jjjj)', 'opgericht');
				echo form_input(array('type' => 'date',
					'name' => 'opgericht',
					'id' => 'opgericht',
					'value' => zetOmNaarDDMMYYYY($brouwerij->oprichting),
					'class' => 'form-control',
					'placeholder' => 'dd/mm/jjjj',
					'required' => 'required'));
			?>
			<div class="valid-feedback">OK</div>
			<div class="invalid-feedback">Vul dit veld in in de vorm dd/mm/jjjj</div></div>
			<br><?php
				echo form_submit("verzenden", "verzenden");
			?></div>
	</div>

	<?php
		echo form_close();
	?>
</div>

<div class='col-12 mt-4'> <?php echo anchor('home', 'Terug'); ?> </div>
