<div class="col-12">
	<?php echo form_open("#"); ?>
	<div>

	</div>
	<?php echo form_close(); ?>
</div>

<table class="table table-hover table-borderless table-responsive-lg">
	<tr>
		<th colspan="2">Mail bewerken</th>
	</tr>
	<tr>
		<td><?php echo form_label("Onderwerp:", "OnderwerpLabel"); ?></td>
		<td><?php echo form_input(array('name' => 'mailOnderwerp',
				'id' => 'mailOnderwerp',
				'class' => 'form-control',
				'placeholder' => 'Onderwerp',
				'required' => 'required',
			)); ?></td>
	</tr>
	<tr>
		<td><?php echo form_label("Tekst:", "TekstLabel"); ?></td>
		<td><?php echo form_textarea(array('name' => 'mailTekst',
				'id' => 'mailTekst',
				'class' => 'form-control',
				'placeholder' => 'Schrijf hier uw mail inhoud',
				'required' => 'required',
			)); ?></td>
	</tr>
	<tr>
		<td colspan="2" class="text-right"><?php
				$opslaanButton = array('class' => 'btn btn-danger opslaan mr-3',  'data-toggle' => 'tooltip',
					"title" => "Mail opslaan");
				echo form_button("knopOpslaan", ' Opslaan', $opslaanButton); ?>
			<!--					</td>-->
			<!--					<td>-->
			<?php
				$annuleerButton = array('class' => 'btn btn-danger annuleren',  'data-toggle' => 'tooltip',
					"title" => "Mail opslaan");
				echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton); ?>
		</td>

	</tr>
</table>
