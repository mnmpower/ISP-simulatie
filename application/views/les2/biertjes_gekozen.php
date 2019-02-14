<div class="col-12 mt-3 row">

	<?php
		if ($producten != null){
		foreach ($producten as $product) {
			echo "<div class='col-3'>". img(array("src" => "/assets/images/fotos/$product->afbeelding", "alt" => "$product->naam"))  ."</div>";
			echo "<div class='col-8'><h4>$product->naam</h4>$product->uitleg</div>";
		}}
	?>
</div>

<div class="col-12 mt-4"><a id="terug" href="javascript:history.go(-1);">Terug</a></div>
