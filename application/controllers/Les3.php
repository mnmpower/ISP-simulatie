<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property Template $template
     * @property Product_model $product_model
     * @property Brouwerij_model $brouwerij_model
     * @property Bestelling_model $bestelling_model
	 * @property Soort_model $soort_model
     */
    class Les3 extends CI_Controller
    {

        // +----------------------------------------------------------
        // | Lekkerbier
        // +----------------------------------------------------------
        // | 2 ITF - 201x-201x
        // +----------------------------------------------------------
        // | Les3 controller
        // |
        // +----------------------------------------------------------
        // | Thomas More Kempen
        // +----------------------------------------------------------

        public function __construct()
        {
            parent::__construct();

            $this->load->helper('notation');
            $this->load->helper('form');
        }

        public function toonFormulierMetDialoogvenster()
        {
            $data['titel'] = 'Formulier met dialoogvenster';

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/formulierMetDialoogvenster');
            $this->template->load('main_master', $partials, $data);
        }

        public function toonTijdDatum()
        {
            $data['titel'] = 'Actuele tijd/datum ophalen';

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/voorbeeld_tijd');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_DatumTijd()
        {
            $watDoen = $this->input->get('watDoen');

            if ($watDoen == 'tijd') {
                $data['tekst'] = "Het is nu " . date('H:i:s');
            } else {
                $data['tekst'] = "Het is vandaag " . date('d/m/Y');
            }

            $this->load->view("les3/ajax_tijd_datum", $data);
        }

        public function toonProductlijst()
        {
            $data['titel'] = 'Formulier + dialoogvenster met Ajax';

            $this->load->model('product_model');
            $data['producten'] = $this->product_model->getAllByNaam();

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/productlijst');

            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Product()
        {
            // hier vervolledigen (oef 3a)
			$productId = $this->input->get('productId');
			$this->load->model('product_model');
			$data['product'] = $this->product_model->get($productId);

            $this->load->view("les3/ajax_product", $data);
        }

        public function zoekBestellingen()
        {
            $data['titel'] = 'Bestellingen';

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/bestellingen_zoeken');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Bestellingen()
        {
            $zoekstring = $this->input->get('zoekstring');

            $this->load->model('bestelling_model');
            $data['bestellingen'] = $this->bestelling_model->getAllByNaamLikeNaam($zoekstring);

            $this->load->view('les3/ajax_bestellingen', $data);
        }

        public function toonBrouwerijen()
        {
            $data['titel'] = 'Brouwerijen';

            $this->load->model('brouwerij_model');
            $data['brouwerijen'] = $this->brouwerij_model->getAllByNaam();

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/brouwerijen');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Brouwerij()
        {
            // hier vervolledigen (oef 2a)
			$brouwerijId= $this->input->get('brouwerijId');

			$this->load->model('brouwerij_model');
			$data['brouwerij'] = $this->brouwerij_model->get($brouwerijId);

            $this->load->view("les3/ajax_brouwerij", $data);
        }

        public function toonSoortProduct()
        {
            $data['titel'] = 'Soort/product Ajax';

            // hier vervolledigen (oef 4 - stap 1)
			$this->load->model('soort_model');
			$data['soorten'] = $this->soort_model->getAllByNaam();

            $partials = array('hoofding' => 'les3/hoofding',
                'inhoud' => 'les3/soort_product');

            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Producten()
        {
            // hier vervolledigen (oef 4 - stap 2)
			$soortId = $this->input->get('soortId');

			$this->load->model('product_model');
			$data['producten'] = $this->product_model->getAllByNaamWhereSoort($soortId);

            $this->load->view('les3/ajax_producten', $data);
        }

    }
