<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
	 * @property Soort_model $soort_model
     */
    class Home extends CI_Controller
    {
        // +----------------------------------------------------------
        // | Project APP Team 22
        // +----------------------------------------------------------
        // | 2 ITF - 2018-2019
        // +----------------------------------------------------------
        // | Home controller
        // +----------------------------------------------------------
        // | G. Bogaerts, T. Ingelaere, S. Kempeneer,  J. Michiels, M. Michiels
        // +----------------------------------------------------------

        public function __construct()
        {
            parent::__construct();
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('cookie');
			$this->load->helper('notation');
			$this->load->helper('notation_helper');


			$this->load->library('session');
			$this->load->library('pagination');

			$this->load->model('product_model');
        }

        public function index()
        {
            $data['titel'] = 'Home';

            // ROLLEN VAN PAGINA
            $data['maartenRol'] = null;
            $data['tijlRol'] = null;
            $data['sachaRol'] = null;
            $data['jinteRol'] = null;

            $knoppen = array(  'knop1' => 'Link1',
                'knop2' => 'Link2',
                'knop3' => 'Link3');

            $data['knoppen'] = $knoppen;

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'main_inhoud',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
