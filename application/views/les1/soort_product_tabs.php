<div class="col-12 mt-3">
    <!--    Programmeer hier je tabs-->
	<ul class="nav nav-tabs">
		<?php
			$teller=0;
			foreach ($soorten as $soort)
			{
				if ($teller == 0){
					echo "<li class='nav-item'><a class='nav-link active' data-toggle='tab' href='#soort".$soort->id."'>$soort->naam</a></li>";
					$teller++;
				}
				else{
					echo "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#soort".$soort->id."'>$soort->naam</a></li>";
				}
			}
		?>
	</ul>
	<div class="tab-content">
		<?php
			$teller = 0;
			foreach ($soorten as $soort)
			{
				if ($teller==0)
				{
					echo "\n<div id='soort".$soort->id."' class='tab-pane fade show active p-3'>";
					foreach ($soort->producten as $product){
						echo smallDivAnchor('/les1/toonDetail/'.$product->id, $product->naam);
					}
					echo "</div>";
					$teller++;
				} else {
					echo "<div id='soort".$soort->id."' class='tab-pane fade p-3'>";
					foreach ($soort->producten as $product){
						echo smallDivAnchor('/Les1/toonDetail/'.$product->id, $product->naam);
					}
					echo "</div>";
				}
			}
		?>

	</div>
</div>

<div class='col-12 mt-4'> <?php echo anchor('home', 'Terug'); ?> </div>
