<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Docent
     * @brief Controllerklasse voor de docent
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de docent
     * @property Template $template
	 * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
	 * @property Les_model $les_model
     * @property Klas_model $klas_model
     */
    class Docent extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Docent.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Docent controller 										 | \\
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
			$this->load->model('persoonLes_model');
			$this->load->model('Les_model');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('docent');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

			$ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

			foreach ($ingediendeIspStudenten as $persoon){

				$persoon->persoonLessen = $this->persoon_model->getAllPersoonLesWithLesAndVak($persoon);
				$persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);
			}

			$data['ingediendeIspStudenten'] = $ingediendeIspStudenten;


			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Docent/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }


        public function showAfspraken() {
            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');
            $this->load->model('Les_model');

            $data['title'] = "Overzicht van de ingediende ISP simulaties";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar;
            $data['buttons'] = getNavbar('docent');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Docent/overzichtAfspraken',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
