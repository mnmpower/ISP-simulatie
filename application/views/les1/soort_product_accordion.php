
<div class="col-12 mt-3" id="accordionVoorbeeld">
	<!--Programmeer hier je accordion-->
	<?php
		$teller =1;
		foreach ($soorten as $soort){
			echo "<div class='card'>\n";
			echo "<div class='card-header'>\n";
			echo "<h4><a data-toggle='collapse' href='#collapse$teller'>$soort->naam</a></h4>\n";
			echo "</div>\n";
			echo "<div id='collapse$teller' class='collapse";
 			if ($teller == 1){
				echo  " show";
			}
 			echo "' data-parent='#accordionVoorbeeld'\n>";
			echo "<div class='card-body'>\n";
			foreach ($soort->producten as $product){
				echo divAnchor(base_url("/index.php/les1/toonDetail/$product->id"),$product->naam);
			}
			echo "</div>\n";
			echo "</div>\n";
			echo "</div>\n";
			$teller++;
		}
	?>

<div class='col-12 mt-4'><?php echo anchor('home', 'Terug'); ?></div>
