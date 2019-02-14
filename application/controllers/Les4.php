<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
     * @property Product_model $product_model
     * @property Brouwerij_model $brouwerij_model
     */
    class Les4 extends CI_Controller
    {

        // +----------------------------------------------------------
        // | Lekkerbier
        // +----------------------------------------------------------
        // | 2 ITF - 201x-201x
        // +----------------------------------------------------------
        // | Les4 controller
        // +----------------------------------------------------------
        // | Thomas More Kempen
        // +----------------------------------------------------------

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('notation');
            $this->load->helper('form');
        }

        public function toonProduct()
        {
            $data['titel'] = 'Product';

            $partials = array('hoofding' => 'les4/hoofding',
                'inhoud' => 'les4/product_form');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalJsonOp_Product()
        {
            $id = $this->input->get('productId');

            $this->load->model('product_model');
            $product = $this->product_model->get($id);
            $product->graden = zetOmNaarKomma($product->graden);

            $this->output->set_content_type('application/json');
            echo json_encode($product);

        }

        public function toonProducten()
        {
            $data['titel'] = 'Producten';

            $partials = array('hoofding' => 'les4/hoofding',
                'inhoud' => 'les4/producten_form');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalJsonOp_Producten()
        {
            $soortId = $this->input->get('soortId');

            $this->load->model('product_model');
            $producten = $this->product_model->getAllByNaamWhereSoort($soortId);

            $this->output->set_content_type("application/json");
            echo json_encode($producten);
        }

        public function toonBrouwerij()
        {
            $data['titel'] = 'Brouwerij';

            $partials = array('hoofding' => 'les4/hoofding',
                'inhoud' => 'les4/brouwerij_form');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalJsonOp_Brouwerij()
        {
            $id = $this->input->get('brouwerijId');

            $this->load->model('brouwerij_model');
            $brouwerij = $this->brouwerij_model->getWithProducten($id);
            $brouwerij->oprichting = zetOmNaarDDMMYYYY($brouwerij->oprichting);

            $this->output->set_content_type("application/json");
            echo json_encode($brouwerij);
        }

        public function haalJsonOp_ProductenPerBrouwerij()
        {
            // hier vervolledigen (oef 1)
			$id = $this->input->get('brouwerijId');

			$this->load->model('product_model');
			$producten = $this->product_model->getAllByNaamWhereBrouwerij($id);

			$this->output->set_content_type("application/json");
			echo json_encode($producten);
        }

        public function tabsJson()
        {
            $data['titel'] = 'Brouwerij/product tab';

            $this->load->model('brouwerij_model');
            $data['brouwerijen'] = $this->brouwerij_model->getAllByNaam();

            $partials = array('hoofding' => 'les4/hoofding', 'inhoud' => 'les4/tabs_json');
            $this->template->load('main_master', $partials, $data);
        }

    }
