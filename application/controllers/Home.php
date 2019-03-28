<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Home
     * @brief Controllerklasse voor de homepagina
     *
     * Controller-klasse met alle methodes die gebruikt worden in de homepagina
     *
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

        /**
         * Constructor
         */
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


        /**
         * Haalt het persoon-record op via Authex
         * Kijkt na of de opgehaalde persoon is aangemeld
         * Verwijst naar de juist methode afhankelijk van het typeId van de persoon indien aangemeld
         * Toont de view index.php indien niet aangemeld
         * @see Authex::getGebruikerInfo()
         * @see Authex::isAangemeld()
         * @see index.php
         */
        public function index()
        {
            $persoon = $this->authex->getGebruikerInfo();

            $data['title'] = "Login";
            $data['persoon'] = $persoon;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');


            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

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

        /**
         * Toont de view wachtwoordWijzigen.php
         * @see wachtwoordWijzigen.php
         */
        public function showWachtwoordWijzigen() {
            $data['title'] = "Wachtwoord wijzigen";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','Tester');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'wachtwoordWijzigen',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Wijzigt en beveiligt het wachtwoord van de ingegeven gebruiker
         * @see Authex::secureEditPassword()
         */
        public function editPassword() {
            $nummer = $this->input->get('nummer');
            $password = $this->authex->secureEditPassword($nummer);
            echo $password;
        }

        /**
         * Controleert of de inloggegevens correct zijn
         * Verwijst naar de juist methode afhankelijk van het typeId van de persoon en correctheid van de inloggegevens
         * @see Authex::meldAan()
         */
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

        /**
         * Meld de gebruiker af
         * @see Authex::meldAf()
         */
        public function uitloggen() {
            $this->authex->meldAf();
            redirect('home/index');
        }

        /**
         * Toont de view fout.php
         * @see fout.php
         */
        public function toonFout($foutmelding) {
            $data['title'] = "Fout";
            $data['foutmelding'] = $foutmelding;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'fout',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Geeft foutmelding mee bij het fout inloggen
         */
        function toonFoutInloggen() {
            $this->toonFout("Gelieve te controleren of uw gebruikersnaam en wachtwoord kloppen.");
        }
    }
