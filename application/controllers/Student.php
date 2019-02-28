<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
	 * @property Persoon_model $persoon_model
     */
    class Student extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Student.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Student controller 									 | \\
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
            $data['title'] = "";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'Student/index',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
