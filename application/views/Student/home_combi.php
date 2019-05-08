<?php
    /**
    * @file home_combi.php
    * View waarin de homepagina van een combistudent wordt weergegeven
    */
?>
<div class="container70">
    <h1>Menu Combi</h1>
    <?php
    $attributen = array(    'name'  => 'mijnFormulier',
        'id'    => 'mijnFormulier',
        'class' => 'formMenu',
        'role'  => 'form');

    echo form_open('student/keuzemenu', $attributen);
    $ispattributen = array('name' => 'isp2', "id" => "isp2", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('isp2', 'ISP-simulatie maken', $ispattributen);
    $vakattributen = array('name' => 'vakken', "id" => "vakken", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('vakken', 'Vakken per fase bekijken', $vakattributen);
    $afspraakattributen = array('name' => 'afspraak', "id" => "afspraak", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('afspraak', 'Afspraak maken', $afspraakattributen);
    echo form_close();
    ?>
</div>