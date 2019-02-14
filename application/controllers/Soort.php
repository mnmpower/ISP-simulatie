<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Soort_model $soort_model
     * @property Product_model $product_model
     * @property Template template
     */
    class Soort extends CI_Controller
    {
        // +----------------------------------------------------------
        // | Lekkerbier
        // +----------------------------------------------------------
        // | 2 ITF - 2018-2019
        // +----------------------------------------------------------
        // | Soort controller
        // +----------------------------------------------------------
        // | Thomas More Kempen
        // +----------------------------------------------------------

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('form');
        }

        public function index()
        {
            $data['titel'] = 'CRUD Soorten';

            $partials = array('hoofding' => 'les4/hoofding',
                'inhoud' => 'les4/soort/overzicht');
            $this->template->load('main_master', $partials, $data);
        }

        public function controleerJson_DubbelSoort()
        {
            $soortNaam = $this->input->post('soortNaam');
            $soortId = $this->input->post('soortId');

            $this->load->model('soort_model');

            $soort = new stdClass();
            $soort = $this->soort_model->getWhereNaam($soortNaam);

            $isDubbel = false;

            if (count($soort) > 0) {
                // soort aanpassen en op wijzigen drukken zonder naam aan te passen => $isDubbel = false
                if (($soort->id === $soortId)) {
                    $isDubbel = false;
                } else {
                    $isDubbel = true;
                }
            }
            $this->output->set_content_type("application/json");
            echo json_encode($isDubbel);
        }

        public function haalAjaxOp_Soorten()
        {
            $this->load->model('soort_model');
            $data['soorten'] = $this->soort_model->getAllByNaam();

            $this->load->view('les4/soort/ajax_lijst', $data);
        }

        public function haalJsonOp_Soort()
        {
            $id = $this->input->get('soortId');

            $this->load->model('soort_model');
            $object = $this->soort_model->get($id);

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

        public function haalJsonOp_SoortMetProducten()
        {
            $soortId = $this->input->get('soortId');
            $this->load->model('soort_model');
            $soort = $this->soort_model->get($soortId);

            $this->load->model('product_model');
            $soort->producten = $this->product_model->getAllByNaamWhereSoort($soortId);

            $this->output->set_content_type("application/json");
            echo json_encode($soort);
        }

        public function schrapAjax_Soort()
        {
            $soortId = $this->input->get('soortId');

            //eerst alle biertjes verwijderen die bij deze soort horen (anders database-error: foreign key constraint)
            $this->load->model('product_model');
            $this->product_model->deleteAllWhereSoort($soortId);

            //soort zelf nog verwijderen
            $this->load->model('soort_model');
            $this->soort_model->delete($soortId);
        }

        public function schrijfAjax_Soort()
        {
            $object = new stdClass();
            $object->id = $this->input->post('soortId');
            $object->naam = $this->input->post('soortNaam');

            $this->load->model('soort_model');

            if ($object->id == 0) {
                //nieuw record
                $this->soort_model->insert($object);
            } else {
                //bestaand record
                $this->soort_model->update($object);
            }
        }
    }
