<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
	 * @property Persoon_model $persoon_model
     * @property Mail_model $mail_model
     * @property Authex $authex
     *
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
            $persoon = $this->authex->getGebruikerInfo();

            $data['title'] = "Login";
            $data['persoon'] = $persoon;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            if($this->authex->isAangemeld()) {
                switch ($persoon->typeId) {
                    case 1:
                        redirect('student/index');
                        break;
                    case 2:
                        redirect('docent/index');
                        break;
                    case 3:
                        redirect('ispVerantwoordelijke/index');
                        break;
                    case 4:
                        redirect('opleidingsmanager/index');
                        break;
                    default:
                        redirect('home/toonFoutInloggen'); //Foutmelding
                        break;
                }
            }

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'index',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function showWachtwoordWijzigen() {
            $data['title'] = "Wachtwoord wijzigen";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','Tester');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'wachtwoordWijzigen',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function editPassword() {
            $nummer = $this->input->post('nummer');
            $this->authex->secureEditPassword($nummer);
            redirect('home/index');
        }

        public function controleerInloggen() {
            $nummer = $this->input->post('nummer');
            $wachtwoord = $this->input->post('wachtwoord');

            $persoon = $this->authex->meldAan($nummer, $wachtwoord);
            if ($persoon != false) {
                switch ($persoon->typeId) {
                    case 1:
                        redirect('student/index');
                        break;
                    case 2:
                        redirect('docent/index');
                        break;
                    case 3:
                        redirect('ispVerantwoordelijke/index');
                        break;
                    case 4:
                        redirect('opleidingsmanager/index');
                        break;
                    default:
                        redirect('home/toonFoutInloggen'); //Foutmelding
                        break;
                }
            } else {
                redirect('home/toonFoutInloggen'); //Foutmelding
            }
        }

        public function uitloggen() {
            $this->authex->meldAf();
            redirect('home/index');
        }

        public function toonFout($foutmelding) {
            $data['title'] = "Fout";
            $data['foutmelding'] = $foutmelding;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'fout',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        function toonFoutInloggen() {
            $this->toonFout("Gelieve te controleren of uw gebruikersnaam en wachtwoord kloppen.");
        }
    }
