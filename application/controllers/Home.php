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
            $this->load->helper('navbar_helper');


			$this->load->library('session');
			$this->load->library('pagination');

			$this->load->model('persoon_model');
        }

        public function index()
        {
            $data['title'] = "WIP";

            // Code tijdelijk in comment wegens testen
            // $persoon =$this->persoon_model->get(1);
            // $iedereen = $persoon->naam;

			// $persoon =$this->persoon_model->get(2);
			// $iedereen .= ", " .$persoon->naam;

			// $persoon =$this->persoon_model->get(3);
			// $iedereen .= ", " .$persoon->naam;

			// $persoon =$this->persoon_model->get(4);
			// $iedereen .= ", " .$persoon->naam;

            $data['title'] = "WIP";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','geen');

            // Gets buttons for navbar
            $data['buttons'] = getNavbar('test');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'main_inhoud',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
