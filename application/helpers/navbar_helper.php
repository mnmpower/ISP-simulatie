<?php
// Function determines buttons for each role in the navbar
function getNavbar($role) {
    switch ($role) {
        case 'student':
            $buttons = array(   'Home' => 'index.php');
            break;

        case 'docent':
            $buttons = array(   'Afspraken' =>site_url() . '/docent/showAfspraken');
            break;

        case 'ispverantwoordelijke':
            $buttons = array(   'Afspraken' => 'Link1',
                                'Exporteren' => 'Link2',
                                'Klassen' => 'toonKlaslijsten');
            break;

        case 'opleidingsmanager':
            $buttons = array(   'Afspraken' => 'Link1',
                                'Exporteren' => 'Link2',
                                'Beheer' => 'beheer');
            break;

        default:
            $buttons = array(   'knop1' => 'Link1',
                                'knop2' => 'Link2',
                                'knop3' => 'Link3');
    }
    return $buttons;
}
