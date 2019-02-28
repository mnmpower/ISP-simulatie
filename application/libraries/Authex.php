<?php
/**
 * Created by PhpStorm.
 * User: jinte
 * Date: 28/02/2019
 * Time: 14:35
 */

class Authex
{
    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->model('Home_model');
    }

    function isAangemeld()
    {
        $CI =& get_instance();

        if ($CI->session->has_userdata('gebruiker_id')) {
            return true;
        } else {
            return false;
        }
    }

    function meldAan($login, $wachtwoord)
    {
        $CI =& get_instance();

        $gebruiker = $CI->gebruiker_model->getGebruiker($login, $wachtwoord);

        if ($gebruiker == null) {
            return false;
        } else {
            $CI->session->set_userdata('gebruiker_id', $gebruiker->id);
            return true;
        }
    }

    function meldAf()
    {
        $CI =& get_instance();

        $CI->session->unset_userdata('gebruiker_id');
    }
}