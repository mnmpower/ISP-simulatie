<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Opleidingsmanager
     * @brief Controllerklasse voor de opleidingsmanager
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de opleidingsmanager
     * @property Template $template
	 * @property Persoon_model $persoon_model
	 * @property Mail_model $mail_model
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

        /**
         * Haalt de persoon-records met ispIngediend=1 (en berekent het aantal opgenomen studiepunten) op via Persoon_model
         * en toont het resulterende object in de view index.php
         * @see Persoon_model::getAllWhereIspIngediend()
         * @see PersoonLes_model::getAllWithLesAndVakAndKlas()
         * @see Les_model::getAllWithVakAndKlasWhereKlas()
         * @see Persoon_model::getStudiepunten()
         * @see index.php
         */
        public function index()
        {
			$this->load->model('persoon_model');
			$this->load->model('persoonLes_model');
			$this->load->model('Les_model');
			$this->load->helper('plugin_helper');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','Tester','geen','geen');

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
                redirect('Opleidingsmanager/vakBeheer');
            }
            else if(isset($_POST['gebruikers']))
            {
				redirect('Opleidingsmanager/gebruikerBeheer');
            }
            else if(isset($_POST['klassen']))
            {
				redirect('Opleidingsmanager/klasBeheer');
            }
            else if(isset($_POST['lessen']))
            {
				redirect('Opleidingsmanager/lesBeheer');
            }
            else if(isset($_POST['mails']))
            {
				redirect('Opleidingsmanager/mailBeheer');
            }
            else if(isset($_POST['keuzerichtingen']))
            {
				redirect('Opleidingsmanager/keuzerichtingBeheer');
            }
        }

        /**
         * Haalt alle keuzerichting-records op via Keuzerichting_model
         * en toont het resulterende object in de view vakBeheer.php
         * @see Keuzerichting_model::getAll()
         * @see vakBeheer.php
         */
        public function vakBeheer()
        {
            $data['title'] = "Vakken beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $this->load->model('keuzerichting_model');

            $keuzerichtingen = $this->keuzerichting_model->getAll();
            $data['keuzerichtingen'] = $keuzerichtingen;

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/vakBeheer',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt de vak-records met fase=$faseId en keuzerichtingId=$keuzerichtingId op via Vak_model en KeuzerichtingVak_model
         * en toont het resulterende object in de view ajax_vakBeheer
         * Deze view wordt via een ajax-call in vakBeheer.php geplaatst
         * @see Vak_model::getAllWhereKeuzerichtingAndFase($keuzerichtingId, $faseId)
         * @see ajax_vakBeheer.php
         * @see vakBeheer.php
         */
        public function haalAjaxOp_Vakken() {
            $keuzerichtingId = $this->input->get('keuzerichtingId');
            $faseId = $this->input->get('faseId');

            $this->load->model('vak_model');

            $vakken = $this->vak_model->getAllWhereKeuzerichtingAndFase($keuzerichtingId, $faseId);
            $data['vakken'] = $vakken;

            $this->load->view('Opleidingsmanager/ajax_vakBeheer', $data);
        }

		public function gebruikerBeheer()
		{
            $data['title'] = "Gebruikers beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/beheergebruikers',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
		}

		public function klasBeheer()
		{
		}

		public function lesBeheer()
		{
		}

		public function mailBeheer()
		{
			//loaden model
			$this->load->model("mail_model");

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$data['title'] = "Mails beheren";

			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'opleidingsmanager/mailBeheer',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}

		public function keuzerichtingBeheer()
		{
		}

		public function haalAjaxOp_Mails(){

			$this->load->model('mail_model');
			$data['mails'] = $this->mail_model->getAllMail();

			$this->load->view('Opleidingsmanager/ajax_MailCRUD', $data);
		}

		public function voegMailToe(){

			$this->load->model("mail_model");

			$mail = new stdClass();
			$mail->id = $this->input->post('mailId');
			$mail->onderwerp = $this->input->post("mailOnderwerp");
			$mail->tekst = $this->input->post("mailTekst");


			if ($mail->id == 0) {
				//nieuw record
				$this->mail_model->insert($mail);
			} else {
				//bestaand record
				$this->mail_model->update($mail);
			}
			redirect('Opleidingsmanager/mailBeheer');
		}

		public function schrapAjax_Mail() {
			$this->load->model("mail_model");

        	$mailId = $this->input->get('mailId');

        	$this->mail_model->delete($mailId);

		}


		public function haalJsonOp_Mail(){
			$id = $this->input->get('mailId');

			$this->load->model("mail_model");
			$mail = $this->mail_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($mail);
		}
    }
