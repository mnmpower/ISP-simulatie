<?php
	/**
	 * @file ajax_jaarvakken.php
	 * Ajaxpagina waarin de jaarvakken per keuzerichting en fase worden weergeven
	 */
?>
<h3>Fase 1</h3>
<div class="row">
	<div class="col-6">
		<h3>Semester 1</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F1S1 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 1 && $vak->semester == 1) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F1S1 = false;
					}
					if ($vak->fase == 1 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F1S1 = false;
					}
				}

				if ($F1S1) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
	<div class="col-6">
		<h3>Semester 2</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F1S2 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 1 && $vak->semester == 2) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F1S2 = false;
					}
					if ($vak->fase == 1 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F1S2 = false;
					}
				}
				if ($F1S2) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
</div>
<h3>Fase 2</h3>
<div class="row">
	<div class="col-6">
		<h3>Semester 1</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F2S1 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 2 && $vak->semester == 1) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F2S1 = false;
					}
					if ($vak->fase == 2 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F2S1 = false;
					}
				}
				if ($F2S1) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
	<div class="col-6">
		<h3>Semester 2</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F2S2 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 2 && $vak->semester == 2) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F2S2 = false;
					}
					if ($vak->fase == 2 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F2S2 = false;
					}
				}
				if ($F2S2) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
</div>
<h3>Fase 3</h3>
<div class="row">
	<div class="col-6">
		<h3>Semester 1</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F3S1 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 3 && $vak->semester == 1) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F3S1 = false;
					}
					if ($vak->fase == 3 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F3S1 = false;
					}
				}
				if ($F3S1) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
	<div class="col-6">
		<h3>Semester 2</h3>
		<table class="table">
			<tr>
				<th style="width: 60%">Vak</th>
				<th style="width: 40%">Studiepunten</th>
			</tr>
			<?php
				$F3S2 = true;
				foreach ($vakken as $vak) {
					if ($vak->fase == 3 && $vak->semester == 2) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F3S2 = false;
					}
					if ($vak->fase == 3 && $vak->semester == 3) {
						echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
						$F3S2 = false;
					}
				}
				if ($F3S2) {
					echo '<tr><td colspan="2"><i class="fas fa-info-circle fa-lg"></i> Er zijn geen vakken in dit semester voor deze richting</td></tr>';
				}
			?>
		</table>
	</div>
</div>
