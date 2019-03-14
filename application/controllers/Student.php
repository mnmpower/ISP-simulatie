<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Student
     * @brief Controllerklasse voor de student
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de student
     * @property Template $template
	 * @property Persoon_model $persoon_model
     * @property Authex $authex
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
            $this->load->helper('plugin_helper');


			$this->load->library('session');
			$this->load->library('pagination');

			$this->load->model('persoon_model');
        }

        public function index()
        {
            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'Student/index',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function home_student()
        {
            $inhoud = '';
            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            if(isset($_POST['model']))
            {
                $inhoud = 'Student/home_model';
            }
            else if(isset($_POST['combi']))
            {
                $inhoud = 'Student/home_combi';
            }

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => $inhoud,
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function keuzemenu()
        {
            if(isset($_POST['klasvoorkeur']))
            {
                redirect('Student/klasvoorkeur');
            }
            else if(isset($_POST['vakken']))
            {
                redirect('Student/toonJaarvakken');
            }
            else if(isset($_POST['afspraak']))
            {
                redirect('Student/showAfspraakmaken');
            }
            else if(isset($_POST['uurrooster']))
            {
            }
            else if(isset($_POST['isp']))
            {
            }
        }

        public function klasvoorkeur()
        {
            $this->load->model('klas_model');

            $data['title'] = "Klasvoorkeur doorgeven";

            $klassen = $this->klas_model->getAllKlassen();
            $data['klassen'] = $klassen;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/klasvoorkeur',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function voorkeurBevestigen(){

            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $persoon = $this->authex->getGebruikerInfo();

            $klasId = $this->input->get('klasId');
            $this->load->model('klas_model');
            $this->persoon_model->setKlasIdWhereNummer($persoon->id, $klasId);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/home_model',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function toonJaarvakken()
        {
            $data['title'] = "Jaarvakken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $this->load->model('keuzerichting_model');
            $data['keuzerichtingen'] = $this->keuzerichting_model->getAll();

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/jaarvakken_raadplegen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Vakken() {
            $keuzerichtingId = $this->input->get('keuzerichtingId');

            $this->load->model('keuzerichtingVak_model');
            $data['vakken'] = $this->keuzerichtingVak_model->getAllWithVakWhereKeuzerichting($keuzerichtingId);

            $this->load->view('student/ajax_jaarvakken', $data);
        }

        public function showAfspraakmaken() {
            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');
            $this->load->model('Les_model');

            $data['title'] = "Afspraak maken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar;
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/afspraakMaken',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
