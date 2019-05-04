<?php
/**
 * @file home_model.php
 * View waarin de homepagina van een modelstudent wordt weergegeven
 */
?>
<div class="container">
    <h1>Menu model</h1>
    <?php
    $attributen = array(    'name'  => 'mijnFormulier',
        'id'    => 'mijnFormulier',
        'role'  => 'form');

    echo form_open('student/keuzemenu', $attributen);
    $klasattributen = array('name' => 'klasvoorkeur', "id" => "klasvoorkeur", 'class' => 'form-control');
    echo form_submit('klasvoorkeur', 'Klasvoorkeur geven', $klasattributen);
    $vakattributen = array('name' => 'vakken', "id" => "vakken", 'class' => 'form-control');
    echo form_submit('vakken', 'Vakken per fase bekijken', $vakattributen);
    $uurroosterattributen = array('name' => 'uurrooster', "id" => "uurrooster", 'class' => 'form-control');
    echo form_submit('uurrooster', 'Mijn uurrooster ', $uurroosterattributen);
    echo form_close();
    ?>
</div>
