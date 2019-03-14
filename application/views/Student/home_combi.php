<?php
    /**
    * @file home_combi.php
    * View waarin de homepagina van een combistudent wordt weergegeven
    */
?>
<h1>Menu Combi</h1>
<?php
$attributen = array(    'name'  => 'mijnFormulier',
    'id'    => 'mijnFormulier',
    'role'  => 'form');

echo form_open('student/keuzemenu', $attributen);
$ispattributen = array('name' => 'isp', "id" => "isp", 'class' => 'form-control');
echo form_submit('isp', 'ISP-simulatie maken', $ispattributen);
$vakattributen = array('name' => 'vakken', "id" => "vakken", 'class' => 'form-control');
echo form_submit('vakken', 'Vakken per fase bekijken', $vakattributen);
$afspraakattributen = array('name' => 'afspraak', "id" => "afspraak", 'class' => 'form-control');
echo form_submit('afspraak', 'Afspraak voor hulp maken', $afspraakattributen);
echo form_close();
?>