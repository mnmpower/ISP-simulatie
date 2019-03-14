<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class IspVerantwoordelijke
     * @brief Controllerklasse voor de ispverantwoordelijke
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de ispverantwoordelijke
     * @property Template $template
	 * @property Persoon_model $persoon_model
     */
    class IspVerantwoordelijke extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - IspVerantwoordelijke.php			 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | IspVerantwoordelijke controller 						 | \\
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
			$this->load->model('persoon_model');
			$this->load->model('persoonLes_model');
			$this->load->model('Les_model');
			$this->load->helper('plugin_helper');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('ispverantwoordelijke');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

			foreach ($ingediendeIspStudenten as $persoon){

				$persoon->persoonLessen = $this->persoon_model->getAllPersoonLesWithLesAndVak($persoon);
				$persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);
			}

			$data['ingediendeIspStudenten'] = $ingediendeIspStudenten;


			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'IspVerantwoordelijke/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }

        public function toonKlaslijsten(){
            $this->load->model('klas_model');

            $data['title'] = "Klaslijsten raadplegen";

            $klassen = $this->klas_model->getAllKlassen();
            $data['klassen'] = $klassen;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('ispverantwoordelijke');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'IspVerantwoordelijke/klaslijsten',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Klassen() {
            $klasId = $this->input->get('klasId');

            $this->load->model('klas_model');
            $personen = $this->persoon_model->getAllWhereKlas($klasId);
            $data['personen'] = $personen;
            $klas = $this->klas_model->get($klasId);
            $data['klas'] = $klas;


            $this->load->view('IspVerantwoordelijke/ajax_klaslijsten', $data);
        }
    }
