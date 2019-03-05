<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex
{
    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->model('persoon_model');
    }

    function isAangemeld()
    {
        $CI =& get_instance();

        if ($CI->session->has_userdata('persoon_id')) {
            return true;
        } else {
            return false;
        }
    }

    function getGebruikerInfo()
    {
        $CI =& get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('persoon_id');
            return $CI->persoon_model->get($id);
        }
    }

    function meldAan($nummer, $wachtwoord)
    {
        $CI =& get_instance();

        $persoon = $CI->persoon_model->getGebruiker($nummer, $wachtwoord);

        if ($persoon == null) {
            return false;
        } else {
            $CI->session->set_userdata('persoon_id', $persoon->id);
            return true;
        }
    }

    function meldAf()
    {
        $CI =& get_instance();

        $CI->session->unset_userdata('persoon_id');
    }
}
