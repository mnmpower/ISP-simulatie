<?php
    echo "<p>Aantal vrije plaatsen: " . ($klas->maximumAantalModel - count($personen)) . " van de " . $klas->maximumAantalModel . "</p>";
    if (count($personen) != 0){
        echo "<p>Studenten die reeds in de klasgroep zitten:</p>";
        echo "<ul>";
        foreach ($personen as $persoon){
            echo "<li>" . $persoon->naam . "</li>";
        }
    }
    echo "</ul>";
?>