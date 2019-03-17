<script>
	var klasid = "<?php
		echo $klas->id;
		?>";
</script>
<div id="showAfspraakmaken">
	<div id="calendarContainer"><h2 id="<?php ?>">Uurrooster <?php
				echo $klas->naam;
			?></h2>
		<h3>semester 1</h3>
		<div id="calendar">
		</div>

		<?php
			echo form_open('student/uurroosterWeergevenSemester2');
			$attributen = array('class' => 'form-control');
			echo form_submit('semester2', 'Toon semester 2', $attributen);
			echo form_close();
		?>
	</div>
	<script src='<?php echo base_url() ?>assets/js/uurroosterWeergevenSemester1.js'></script>
</div>
