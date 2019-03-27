<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Opleidingsmanager
     * @brief Controllerklasse voor de opleidingsmanager
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de opleidingsmanager
     * @property Template $template
	 * @property Persoon_model $persoon_model
     */
    class Opleidingsmanager extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Opleidingsmanager.php				 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Opleidingsmanager controller 							 | \\
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
			$this->load->model('les_model');
        }

        public function index()
        {
			$this->load->model('persoon_model');
			$this->load->model('persoonLes_model');
			$this->load->model('Les_model');
			$this->load->helper('plugin_helper');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

			foreach ($ingediendeIspStudenten as $persoon){

                if($persoon->klasId == null) {
                    // Persoon zit niet in een klas -> persoonLessen ophalen
                    $persoon->persoonLessen = $this->persoonLes_model->getAllWithLesAndVakAndKlas($persoon->id);
                } else {
                    // Persoon zit wel in een klas -> lessen van de klas ophalen
                    $persoon->persoonLessen = $this->les_model->getAllWithVakAndKlasWhereKlas($persoon->klasId);
                }

				$persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);
			}

			$data['ingediendeIspStudenten'] = $ingediendeIspStudenten;


			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Opleidingsmanager/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }

        public function beheer()
        {
            $data['title'] = "Opleidingsmanager";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/beheermenu',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function keuzeBeheer()
        {
            if(isset($_POST['vakken']))
            {
                redirect('Opleidingsmanager/vakkenBeheer');
            }
            else if(isset($_POST['gebruikers']))
            {
            }
            else if(isset($_POST['klassen']))
            {
            }
            else if(isset($_POST['lessen']))
            {
            }
            else if(isset($_POST['mails']))
            {
            }
            else if(isset($_POST['keuzerichtingen']))
            {
            }
        }

        public function vakkenBeheer()
        {
        }
    }
