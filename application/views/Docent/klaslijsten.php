<script>

</script>
<?php

$klasOpties = array();
$klasOpties[0] = '-- Select --';

foreach ($klassen as $klasOptie) {
    $klasOpties[$klasOptie->id] = $klasOptie->naam;
}
?>
<h1>
    <?php
    echo $title
    ?>
</h1>
<?php
$attributes = array('name' => 'mijnFormulier');
echo form_open('Docent/toonKlaslijsten', $attributes);
$formattributes = array('class' => 'form-control');
echo form_dropdown('klas', $klasOpties, '0', $formattributes);
echo form_submit('submit', 'Submit', $formattributes);
echo form_close();
?>
<?php
if ($klas != ''){
    echo "<p>Aantal vrije plaatsen: " . count($personen) . " van de " . $klas->maximumAantalModel . "</p>";
    echo "<p>Studenten die reeds in de klasgroep zitten:</p>";
    echo "<ul>";
    foreach ($personen as $persoon){
        echo "<li>" . $persoon->naam . "</li>";
    }
    echo "</ul>";
}
?>

