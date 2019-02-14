<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Template $template
 * @property Product_model $product_model
 */
class Les2 extends CI_Controller {

    // +----------------------------------------------------------
    // | Lekkerbier
    // +----------------------------------------------------------
    // | 2 ITF - 201x-201x
    // +----------------------------------------------------------
    // | Les2 controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('form');
    }

    public function toonHalloWereld()
    {
        $data['titel']  = 'Hallo Wereld';

        $partials = array('hoofding' => 'les2/hoofding', 
            'inhoud' => 'les2/hallo_wereld');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function toonWaarschuwingen()
    {
        $data['titel']  = 'Waarschuwingen';

        $partials = array('hoofding' => 'les2/hoofding', 
            'inhoud' => 'les2/waarschuwingen');
        
        $this->template->load('main_master', $partials, $data);
    }

    public function berekenKwadraat()
    {
        $data['titel']  = 'Tweede macht';

        $partials = array('hoofding' => 'les2/hoofding',
            'inhoud' => 'les2/kwadraat');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function toonEffecten()
    {
        $data['titel']  = 'Effecten';

        $partials = array('hoofding' => 'les2/hoofding', 
            'inhoud' => 'les2/effecten');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function roepCallBackOp()
    {
        $data['titel']  = 'Callback';

        $partials = array('hoofding' => 'les2/hoofding',
            'inhoud' => 'les2/callback');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function berekenPlusMin()
    {
        $data['titel']  = 'Plus en min';

        $partials = array('hoofding' => 'les2/hoofding',
            'inhoud' => 'les2/plusmin');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function berekenTafelVanVermenigvuldig()
    {
        $data['titel']  = 'Tafel van vermenigvuldiging';

        $partials = array('hoofding' => 'les2/hoofding', 
            'inhoud' => 'les2/tafel_van_vermenigvuldiging');
        
        $this->template->load('main_master', $partials, $data);
    }

    public function berekenInhoudBalk()
    {
        $data['titel']  = 'Inhoud balk';

        $partials = array('hoofding' => 'les2/hoofding', 
            'inhoud' => 'les2/balk');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function maakRekenmachine()
    {
        $data['titel']  = 'Rekenmachine';

        $partials = array('hoofding' => 'les2/hoofding',
            'inhoud' => 'les2/rekenmachine');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    public function bestel()
    {
        $data['titel']  = 'Biertjes bestellen';

        $this->load->model('product_model');
        $data['producten'] = $this->product_model->getAllByNaam();
        
        $partials = array('hoofding' => 'les2/hoofding',
            'inhoud' => 'les2/biertjes_keuze');
        
        $this->template->load('main_master', $partials, $data);
    }

    public function behandelBestelling()
    {
		$this->load->model('product_model');
		$this->load->library('session');


		$ids = $this->input->post("biertjes");
        $teller = 0;

        foreach ($ids as $id){
        	$product = $this->product_model->get($id);
        	$producten[$teller] = $product;
        	$teller ++;
		}

		$this->session->set_userdata('producten', $producten);
		$this->session->set_userdata('titel', 'Biertjes bestellen');


        redirect("les2/toonBestelling");

    }
    public function toonBestelling() {

		$this->load->library('session');

		$data['producten'] = $this->session->userdata('producten');
		$data['titel']  = $this->session->userdata('titel');

		$this->session->unset_userdata('producten');

		$partials = array('hoofding' => 'les2/hoofding',
			'inhoud' => 'les2/biertjes_gekozen');

		$this->template->load('main_master', $partials, $data);

	}
    
}
