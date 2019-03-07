<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex
{
    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->model('persoon_model');
        $CI->load->model('mail_model');
        $CI->load->library('email');
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
            return $persoon;
        }
    }

    function meldAf()
    {
        $CI =& get_instance();

        $CI->session->unset_userdata('persoon_id');
    }

    function secureEditPassword($nummer) {
        $CI =& get_instance();
        $generatedPassword = $this->generateRandomString(5);
        $secureGeneratedPassword = password_hash($generatedPassword, PASSWORD_DEFAULT);
        $CI->persoon_model->setWachtwoordWhereNummer($nummer, $secureGeneratedPassword);

        $mail = $CI->mail_model->get(1);
        if ('u' == substr($nummer, 1)) {
            $mailadres = $nummer . '@thomasmore.be';
        }
        else {
            $mailadres = $nummer . '@student.thomasmore.be';
        }
        $CI->email->from('noreply@omnidata.be', 'OmniData');
        $CI->email->to($mailadres);
        $CI->email->subject($mail->onderwerp);
        $CI->email->message(str_replace('(wachtwoord)', $generatedPassword, $mail->tekst));
        $CI->email->send();
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
