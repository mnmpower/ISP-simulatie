<?php
    echo "<p>Aantal vrije plaatsen: " . count($personen) . " van de " . $klas->maximumAantalModel . "</p>";
    echo "<p>Studenten die reeds in de klasgroep zitten:</p>";
    echo "<ul>";
    foreach ($personen as $persoon){
        echo "<li>" . $persoon->naam . "</li>";
    }
    echo "</ul>";
?>