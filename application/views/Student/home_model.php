<?php
/**
 * @file home_model.php
 * View waarin de homepagina van een modelstudent wordt weergegeven
 */
?>
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
    $afspraakattributen = array('name' => 'afspraak', "id" => "afspraak", 'class' => 'form-control');
    echo form_submit('afspraak', 'Afspraak maken', $afspraakattributen);
    $uurroosterattributen = array('name' => 'uurrooster', "id" => "uurrooster", 'class' => 'form-control');
    echo form_submit('uurrooster', 'Uurrooster weergeven', $uurroosterattributen);
    echo form_close();
?>