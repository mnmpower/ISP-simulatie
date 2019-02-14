<?php

// hier vervolledigen (oef 4 - stap 2) (maak alleen de options voor de onderste listbox !!)
// dus bijvoorbeeld: <option value="5">Duvel</option><option value="6">Gouden Carolus</option>
	foreach ($producten as $product){
		echo "<option value='".$product->id."'>$product->naam</option>";
}

?>


