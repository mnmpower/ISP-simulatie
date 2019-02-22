<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
	 * @property Persoon_model $persoon_model
     */
    class Home extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Home.php							 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Home controller 										 | \\
		// +---------------------------------------------------------+ \\
		// | T.Ingelaere, S. Kempeneer, J. Michiels, M. Michiels	 | \\
		// +---------------------------------------------------------+ \\

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

			$this->load->model('persoon_model');
        }

        public function index()
        {
            $persoon =$this->persoon_model->get(1);
            $iedereen = $persoon->naam;

			$persoon =$this->persoon_model->get(2);
			$iedereen .= ", " .$persoon->naam;

			$persoon =$this->persoon_model->get(3);
			$iedereen .= ", " .$persoon->naam;

			$persoon =$this->persoon_model->get(4);
			$iedereen .= ", " .$persoon->naam;

			$data['titel'] = $iedereen;

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
