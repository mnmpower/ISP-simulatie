<div class="col-12 mt-3">
    <!--Programmeer hier je accordion-->
	<div class="col-12 mt-3" id="productAccordion">
		<div class="card">
			<div class="card-header">
				<h4><a data-toggle="collapse" href="#collapse1">Algemeen</a></h4>
			</div>
			<div id="collapse1" class="collapse show" data-parent="#productAccordion">
				<div class="card-body row">
					<div class="col-4"><?php
						 echo img(array("src" => "/assets/images/fotos/$product->afbeelding","alt"=>$product->naam));
					?></div>
					<div class="col-8">
						<?php
							echo "<h3>$product->naam</h3>";
							echo "<p>$product->uitleg</p>";
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4><a data-toggle="collapse" href="#collapse2">Kenmerken</a></h4>
			</div>
			<div id="collapse2" class="collapse" data-parent="#productAccordion">
				<div class="card-body row">
					<div class="col-12">
						<?php
							echo "<p>Soort: ".$product->soort->naam."</p>";
							echo "<p>Graden: $product->graden</p>";
							echo "<p>Prijs: $product->prijs</p>";
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4><a data-toggle="collapse" href="#collapse3">Brouwerij</a></h4>
			</div>
			<div id="collapse3" class="collapse" data-parent="#productAccordion">
				<div class="card-body row">
					<div class="col-12">
						<?php
							echo "<p>Naam: ".$product->brouwerij->naam."</p>";
							echo "<p>Gesticht: ".$product->brouwerij->oprichting."</p>";
							echo "<p>Stichter: ".$product->brouwerij->stichter."</p>";
							echo "<p>Plaats: ".$product->brouwerij->plaats."</p>";
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
