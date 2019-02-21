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

			$this->load->model('$persoon_model');
        }

        public function index()
        {
            $data['titel'] = 'Home';

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'main_inhoud',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
