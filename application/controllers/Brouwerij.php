<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
     * @property Brouwerij_model $brouwerij_model
     */
    class Brouwerij extends CI_Controller
    {

        // +----------------------------------------------------------
        // | Lekkerbier
        // +----------------------------------------------------------
        // | 2 ITF - 2018-2019
        // +----------------------------------------------------------
        // | Brouwerij controller
        // +----------------------------------------------------------
        // | M. Decabooter, J. Janssen
        // +----------------------------------------------------------

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('form');
            $this->load->helper('notation');
        }

        public function index()
        {
            $data['titel'] = 'Brouwerijen beheren';

            $this->load->model('brouwerij_model');
            $data['brouwerijen'] = $this->brouwerij_model->getAllByNaam();

            $partials = array('hoofding' => 'les1/hoofding',
                'inhoud' => 'les1/brouwerij_lijst');

            $this->template->load('main_master', $partials, $data);
        }

        function getEmptyBrouwerij()
        {
            $brouwerij = new stdClass();

            $brouwerij->id = 0;
            $brouwerij->naam = '';
            $brouwerij->stichter = '';
            $brouwerij->plaats = '';
            $brouwerij->werknemers = '';
            $brouwerij->oprichting = date('Y-m-d');

            return $brouwerij;
        }

        public function maakNieuwe()
        {
            $data['brouwerij'] = $this->getEmptyBrouwerij();
            $data['titel'] = 'Brouwerij toevoegen';

            $partials = array('hoofding' => 'les1/hoofding',
                'inhoud' => 'les1/brouwerij_form');

            $this->template->load('main_master', $partials, $data);
        }

        public function wijzig($id)
        {
            $this->load->model('brouwerij_model');
            $data['brouwerij'] = $this->brouwerij_model->get($id);
            $data['titel'] = 'Brouwerij wijzigen';

            $partials = array('hoofding' => 'les1/hoofding',
                'inhoud' => 'les1/brouwerij_form');
            $this->template->load('main_master', $partials, $data);
        }

        public function schrap($id)
        {
            $this->load->model('brouwerij_model');
            $data['brouwerij'] = $this->brouwerij_model->delete($id);

            redirect('/brouwerij/index');
        }

        public function registreer()
        {

        }

        public function onePageCRUD()
		{
			$this->load->model('brouwerij_model');

			$data['titel'] = 'Brouwerij wijzigen';

			$data['brouwerijen'] = $this->brouwerij_model->getAllByNaamWithProducten();

			$partials = array('hoofding' => 'les4/hoofding',
				'inhoud' => 'les4/brouwerij/overzicht');
			$this->template->load('main_master', $partials, $data);
		}

		public function haalAjaxOp_Brouwerijen(){
			$this->load->model('brouwerij_model');
			$data['brouwerijen'] = $this->brouwerij_model->getAllByNaamWithProducten();

			$this->load->view('les4/brouwerij/ajax_lijst', $data);
		}

		public function haalJsonOp_Brouwerij()
		{
			$id = $this->input->get('brouwerijId');

			$this->load->model('brouwerij_model');
			$object = $this->brouwerij_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($object);
		}

		public function schrapAjax_Brouwerij(){
			$brouwerijId = $this->input->get('brouwerijId');

			$this->load->model('brouwerij_model');

			//eerst alle biertjes verwijderen die bij deze soort horen (anders database-error: foreign key constraint)
			$this->load->model('product_model');
			$this->product_model->deleteAllWhereSoort($soortId);

			//soort zelf nog verwijderen
			$this->load->model('soort_model');
			$this->brouwerij_model->delete($brouwerijId);
		}
    }
