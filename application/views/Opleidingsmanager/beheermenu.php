<?php
/**
 * @file beheermenu.php
 * View waarin het menu voor het beheer van de database wordt weergegeven
 */
?>
<div class="container70">
    <h1><i class="fas fa-cog"></i> Beheer</h1>
    <?php
    $attributen = array(    'name'  => 'mijnFormulier',
        'id'    => 'mijnFormulier',
        'role'  => 'form');

    echo form_open('opleidingsmanager/keuzeBeheer', $attributen);
    $vakattributen = array('name' => 'vakken', "id" => "vakken", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('vakken', 'Vakkenbeheer', $vakattributen);
    $gebruikerattributen = array('name' => 'gebruikers', "id" => "gebruikers", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('gebruikers', 'Gebruikersbeheer', $gebruikerattributen);
    $klasattributen = array('name' => 'klassen', "id" => "klassen", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('klassen', 'Klassenbeheer', $klasattributen);
    $lesattributen = array('name' => 'lessen', "id" => "lessen", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('lessen', 'Lessenbeheer', $lesattributen);
    $mailattributen = array('name' => 'mails', "id" => "mails", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('mails', 'Mailbeheer', $mailattributen);
    $keuzerichtingattributen = array('name' => 'keuzerichtingen', "id" => "keuzerichtingen", 'class' => 'form-control btn-outline-dark btn menuButton');
    echo form_submit('keuzerichtingen', 'Keuzerichtingenbeheer', $keuzerichtingattributen);
    echo form_close();
    ?>
</div>
