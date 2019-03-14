<?php
/**
 * @file beheermenu.php
 * View waarin het menu voor het beheer van de database wordt weergegeven
 */
?>
<div class="container">
    <h1>Beheer</h1>
    <?php
    $attributen = array(    'name'  => 'mijnFormulier',
        'id'    => 'mijnFormulier',
        'role'  => 'form');

    echo form_open('ispverantwoordelijke/keuzeBeheer', $attributen);
    $vakattributen = array('name' => 'vakken', "id" => "vakken", 'class' => 'form-control');
    echo form_submit('vakken', 'Vakkenbeheer', $vakattributen);
    $gebruikerattributen = array('name' => 'gebruikers', "id" => "gebruikers", 'class' => 'form-control');
    echo form_submit('gebruikers', 'Gebruikersbeheer', $gebruikerattributen);
    $klasattributen = array('name' => 'klassen', "id" => "klassen", 'class' => 'form-control');
    echo form_submit('klassen', 'Klassenbeheer', $klasattributen);
    $lesattributen = array('name' => 'lessen', "id" => "lessen", 'class' => 'form-control');
    echo form_submit('lessen', 'Lessenbeheer', $lesattributen);
    $mailattributen = array('name' => 'mails', "id" => "mails", 'class' => 'form-control');
    echo form_submit('mails', 'Mailbeheer', $mailattributen);
    $keuzerichtingattributen = array('name' => 'keuzerichtingen', "id" => "keuzerichtingen", 'class' => 'form-control');
    echo form_submit('keuzerichtingen', 'Keuzerichtingenbeheer', $keuzerichtingattributen);
    echo form_close();
    ?>
</div>