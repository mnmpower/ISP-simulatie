<!-- hier vervolledigen (oef 3a) -->

<?php echo img(array("src" => "assets/images/fotos/".$product->afbeelding, "alt" => "$product->naam")); ?>
<h1><?php
		echo $product->naam;
	?>
</h1>
<p>
	<?php
		echo $product->uitleg
	?>
</p>
