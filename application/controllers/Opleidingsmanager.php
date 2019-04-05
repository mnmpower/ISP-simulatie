<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Opleidingsmanager
     * @brief Controllerklasse voor de opleidingsmanager
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de opleidingsmanager
     * @property Template $template
	 * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
	 * @property Keuzerichting_model $keuzerichting_model
	 * @property KeuzerichtingVak_model $keuzerichtingVak_model
	 * @property KeuzerichtingKlas_model $keuzerichtingKlas_model
	 * @property Mail_model $mail_model
     * @property Vak_model $vak_model
	 * @property Klas_model $klas_model
	 * @property Les_model $les_model
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
            $this->load->model('keuzerichtingVak_model');

            $vakken = $this->vak_model->getAllWhereKeuzerichtingAndFase($keuzerichtingId, $faseId);
            $data['vakken'] = $vakken;

            $this->load->view('Opleidingsmanager/ajax_vakBeheer', $data);
        }

        public function voegVakToe(){

            $this->load->model("vak_model");
            $this->load->model("keuzerichtingVak_model");
            $this->load->model('keuzerichting_model');

            $allekeuzerichtingen = $this->keuzerichting_model->getAll();

            $vak = new stdClass();
            $vak->id = $this->input->post('vakId');
            $vak->naam = $this->input->post("vakNaam");
            $vak->studiepunt = $this->input->post("vakStudiepunten");
            $vak->fase = $this->input->post('fase2');
            $vak->semester = $this->input->post('semester');
            $vak->volgtijdelijkheidinfo = $this->input->post("vakOpmerking");
            $keuzerichtingen = $this->input->post('keuzerichtingcheckbox');

            $i = 0;
            $keuzerichtingenId = array();
            foreach ($allekeuzerichtingen as $keuzerichting){
                foreach ($keuzerichtingen as $gekozen){
                    if ($gekozen == $keuzerichting){
                        array_push($keuzerichtingenId, $i);
                    }
                }
                $i++;
            }

            if ($vak->id == 0) {
                //nieuw record
                $this->vak_model->insert($vak);
            } else {
                //bestaand record
                $this->vak_model->update($vak);
            }

            foreach ($keuzerichtingenId as $keuzerichtingId){
                $keuzerichtingvak = new stdClass();
                $keuzerichtingvak->keuzerichtingVakId = $this->input->post('keuzerichtingVakId');
                $keuzerichtingvak->keuzerichtingId = $keuzerichtingId;
                $keuzerichtingvak->vakId = $this->input->post("vakId");
                if ($vak->id == 0) {
                    //nieuw record
                    $this->keuzerichtingVak_model->insert($keuzerichtingvak);
                } else {
                    //bestaand record
                    $this->keuzerichtingVak_model->update($keuzerichtingvak);
                }
            }

            redirect('Opleidingsmanager/vakBeheer');
        }

        public function schrapAjax_Vak() {
            $this->load->model("vak_model");
            $this->load->model("keuzerichtingVak_model");

            $vakId = $this->input->post('vakId');
            $keuzerichtingVakken = $this->keuzerichtingVak_model->getAllWhereVak($vakId);

            foreach ($keuzerichtingVakken as $keuzerichtingVak){
                $this->keuzerichtingVak_model->delete($keuzerichtingVak->id);
            }
            $this->vak_model->delete($vakId);

        }


        public function haalJsonOp_Vak(){
            $vakId = $this->input->get('vakId');

            $this->load->model("vak_model");
            $vak = $this->vak_model->get($vakId);

            $this->load->model("keuzerichtingVak_model");
            $keuzerichtingvakken = $this->keuzerichtingVak_model->getAllWhereVak($vakId);

            $keuzerichtingenId  = array();
            foreach ($keuzerichtingvakken as $keuzerichtingvak){
                array_push($keuzerichtingenId, $keuzerichtingvak->keuzerichtingId);
            }
            $vak->keuzerichting = $keuzerichtingenId;

            $this->output->set_content_type("application/json");
            echo json_encode($vak);
        }

		public function gebruikerBeheer($foutmelding = NULL)
		{
            $data['title'] = "Gebruikers beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            // Gets foutmelding from parameter
            $data['foutmelding'] = $foutmelding;

            $this->load->model('persoonType_model');
            $data['persoonTypes'] = $this->persoonType_model->getAll();

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/beheergebruikers',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
		}

        public function haalAjaxOp_Gebruikers()
        {
            $this->load->model('persoon_model');
            $gebruikers = $this->persoon_model->getAllWithType();
            foreach ($gebruikers as $gebruiker) {
                if($gebruiker->id != 8) {
                    $gebruikersNieuw[] = $gebruiker;
                }
            }
            $data['gebruikers'] = $gebruikersNieuw;

            $this->load->view('opleidingsmanager/ajax_gebruikers', $data);
        }

        public function haalJsonOp_Gebruiker()
        {
            $id = $this->input->get('gebruikerId');

            $this->load->model('persoon_model');
            $object = $this->persoon_model->get($id);

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

        public function schrapAjax_Gebruiker()
        {
            $gebruikerId = $this->input->get('gebruikerId');

            $this->load->model('persoon_model');
            $this->persoon_model->delete($gebruikerId);
        }

        public function controleerJson_DubbelGebruiker()
        {
            $gebruikerId = $this->input->post('gebruikerId');
            $gebruikerNummer = $this->input->post('gebruikerNummer');

            $this->load->model('persoon_model');

            $gebruiker = $this->persoon_model->getWhereNummer($gebruikerNummer);

            $isDubbel = false;

            if (count($gebruiker) > 0) {
                if (($gebruiker->id === $gebruikerId)) {
                    $isDubbel = false;
                } else {
                    $isDubbel = true;
                }
            }
            $this->output->set_content_type("application/json");
            echo json_encode($isDubbel);
        }

        public function schrijfAjax_Gebruiker()
        {
            $object = new stdClass();
            $object->id = $this->input->post('gebruikerId');
            $object->naam = $this->input->post('gebruikerNaam');
            $object->nummer = $this->input->post('gebruikerNummer');
            $object->typeId = $this->input->post('gebruikerType');

            $this->load->model('persoon_model');
            if ($object->id == 0) {
                //nieuw record
                $this->persoon_model->insert($object);
            } else {
                //bestaand record
                $this->persoon_model->update($object);
            }
        }

        public function uploadGebruikersExcel()
        {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'xlsx|xls';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excelFile'))
            {
                redirect('Opleidingsmanager/gebruikerBeheer/fout');
            }
            else
            {
                $upload_data = $this->upload->data();
                $fileName = $upload_data['file_name'];
                $newName = 'gebruikers.xls';
                if(substr($fileName, -4) == "xlsx") {
                    $newName = "gebruikers.xlsx";
                }
                rename('./uploads/' . $fileName, './uploads/' . $newName);

                // Excel file koppelen
                $this->load->library('excel');
                $file = './uploads/' . $newName;
                $excelFile = PHPExcel_IOFactory::load($file);

                // Excel file nakijken
                $A1 = $excelFile->getActiveSheet()->getCell('A1')->getValue();
                $B1 = $excelFile->getActiveSheet()->getCell('B1')->getValue();
                if(strtolower($A1) == "naam" && strtolower($B1) == "nummer") {

                    // Alleen ingevulde cellen selecteren
                    $cell_collection = $excelFile->getActiveSheet()->getCellCollection();

                    // Omzetten naar array
                    foreach ($cell_collection as $cell) {
                        $column = $excelFile->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $excelFile->getActiveSheet()->getCell($cell)->getRow();
                        $cell_value = $excelFile->getActiveSheet()->getCell($cell)->getValue();

                        if($row != 1) {
                            $gebruikers[$row][$column] = $cell_value;
                        }
                    }

                    // Array naar database
                    $this->load->model('persoon_model');
                    $toegevoegd = 0;
                    $totaal = 0;
                    foreach ($gebruikers as $object) {
                        $gebruiker = new stdClass();
                        $gebruiker->naam = $object["A"];
                        $gebruiker->nummer = $object["B"];

                        $gebruiker->id = 0;
                        $gebruiker->typeId = $this->input->post('gebruikerTypeExcel');

                        if($this->persoon_model->getWhereNummer($gebruiker->nummer) == null) {
                            $this->persoon_model->insert($gebruiker);
                            $toegevoegd++;
                        }
                        $totaal++;
                    }

                    // Redirect naar overzicht gebruikers
                    redirect('Opleidingsmanager/gebruikerBeheer/' . $toegevoegd . ' van de ' . $totaal);
                } else {
                    redirect('Opleidingsmanager/gebruikerBeheer/fout');
                }
            }
        }

		//VANAF HEIR MOOI ORDENEN
		public function lesBeheer($foutmelding = NULL)
        {
            $data['title'] = "Lessen beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            // Gets foutmelding from parameter
            $data['foutmelding'] = $foutmelding;

            $this->load->model('vak_model');
            $data['vakken'] = $this->vak_model->getAll();
            $this->load->model('klas_model');
            $data['klassen'] = $this->klas_model->getAllKlassenOrderByNaam();

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/beheerlessen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_Lessen()
        {
            $this->load->model('les_model');
            $data['lessen'] = $this->les_model->getAllWithVakAndKlas();

            $this->load->view('opleidingsmanager/ajax_lessen', $data);
        }

        public function haalJsonOp_Les()
        {
            $id = $this->input->get('lesId');

            $this->load->model('les_model');
            $object = $this->les_model->getWithVakAndKlasAndDag($id);

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

        public function schrapAjax_Les()
        {
            $lesId = $this->input->get('lesId');

            $this->load->model('les_model');
            $this->les_model->delete($lesId);
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
			//loaden model
			$this->load->model("mail_model");

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$data['title'] = "Keuzerichtingen beheren";

			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'opleidingsmanager/BeheerKeuzerichting/KeuzerichtingBeheer',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}

		public function klasBeheer()
		{
			//loaden model
			//$this->load->model("klas_model");

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$data['title'] = "Klassen beheren";

			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'opleidingsmanager/BeheerKlas/KlasBeheer',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}



		public function haalAjaxOp_Mails(){

			$this->load->model('mail_model');
			$data['mails'] = $this->mail_model->getAllMail();

			$this->load->view('Opleidingsmanager/ajax_MailCRUD', $data);
		}

		public function haalAjaxOp_Keuzerichtingen(){
			$this->load->model('keuzerichting_model');
			$data['keuzerichtingen'] = $this->keuzerichting_model->getAll();

			$this->load->view('Opleidingsmanager/BeheerKeuzerichting/ajax_KeuzerichtingCRUD', $data);
		}

		public function haalAjaxOp_Klassen(){
			$this->load->model('klas_model');
			$data['klassen'] = $this->klas_model->getAllKlassenOrderByNaam();

			$this->load->view('Opleidingsmanager/BeheerKlas/ajax_KlasCRUD', $data);
		}



		public function voegMailToe(){

			$this->load->model("mail_model");

			$mail = new stdClass();
			$mail->id = $this->input->post('mailId');
			$mail->onderwerp = htmlspecialchars($this->input->post("mailOnderwerp"));
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

		public function voegKeuzerichtingToe(){
			$this->load->model('keuzerichting_model');

			$keuzerichting = new stdClass();
			$keuzerichting->id = $this->input->post('KeuzerichtingId');
			$keuzerichting->naam = htmlspecialchars($this->input->post("KeuzerichtingNaam"));

			if ($keuzerichting->id == 0) {
				//nieuw record
				$this->keuzerichting_model->insert($keuzerichting);
			} else {
				//bestaand record
				$this->keuzerichting_model->update($keuzerichting);
			}
			redirect('Opleidingsmanager/keuzerichtingBeheer');
		}

		public function voegKlasToe(){
			$this->load->model('klas_model');

			$klas = new stdClass();
			$klas->id = $this->input->post('klasId');
			$klas->naam = htmlspecialchars($this->input->post("klasNaam"));
			$klas->maximumAantal = htmlspecialchars($this->input->post("aantalLeerlingen"));
			$klas->maximumAantalModel = htmlspecialchars($this->input->post("aantalModel"));

			if ($klas->id == 0) {
				//nieuw record
				$this->klas_model->insert($klas);
			} else {
				//bestaand record
				$this->klas_model->update($klas);
			}
			redirect('Opleidingsmanager/klasBeheer');
		}



		public function schrapAjax_Mail() {
			$this->load->model("mail_model");

        	$mailId = $this->input->get('mailId');

        	$this->mail_model->delete($mailId);

		}

		public function schrapAjax_Keuzerichting() {
			$this->load->model('keuzerichting_model');
			$this->load->model('keuzerichtingVak_model');
			$this->load->model('keuzerichtingKlas_model');
			$this->load->model('persoon_model');

        	$keuzerichtingId = $this->input->get('keuzerichtingId');

        	//NAKIJKEN OF ER PERSONEN BESTAAN IN DEZE KEUZERICHTING + AANPASSEN NAAR 0
        	$persoonen = $this->persoon_model->getPersoonWhereKeuzerichtingId($keuzerichtingId);
        	foreach ($persoonen as $persoon){

				$persoon->keuzerichtingId = null;
				$this->persoon_model->update($persoon);
			}

			//ALLE KEUZERICHTING VAKKEN SCHRAPPEN ALS DIE NOG BESTAAN
			$this->keuzerichtingVak_model->deleteAllWhereKeuzerichtingID($keuzerichtingId);
//			$keuzerichtingVakken = $this->keuzerichtingVak_model->getAll();
//			foreach ($keuzerichtingVakken as $item) {
//				if ($item->keuzerichtingId == $keuzerichtingId){
//					$this->keuzerichtingVak_model->delete($item->id);
//				}
//        	}

        	//ALLE KEUZERICHTING KLASSEN SCHRAPPEN ALS DIE NOG BESTAAN
			$this->keuzerichtingKlas_model->deleteAllWhereKeuzerichtingID($keuzerichtingId);
//			$keuzerichtingKlassen = $this->keuzerichtingKlas_model->getAll();
//			foreach ($keuzerichtingKlassen as $item) {
//				if ($item->keuzerichtingId == $keuzerichtingId){
//					$this->keuzerichtingKlas_model->delete($item->id);
//				}
//			}

        	$this->keuzerichting_model->delete($keuzerichtingId);

		}
		//DEZE NOG DOEN
		public function schrapAjax_Klas() {
			$this->load->model('keuzerichtingKlas_model');
			$this->load->model('persoon_model');
			$this->load->model('les_model');
			$this->load->model('klas_model');
			$this->load->model('persoonLes_model');

        	$klasId = $this->input->get('klasId');

        	//NAKIJKEN OF ER PERSONEN BESTAAN IN DEZE KEUZERICHTING + AANPASSEN NAAR 0
        	$persoonen = $this->persoon_model->getPersoonWhereKlasId($klasId);
        	foreach ($persoonen as $persoon){

				$persoon->klasId = null;
				$this->persoon_model->update($persoon);
			}

			//ALLE KEUZERICHTING KLASSEN SCHRAPPEN ALS DIE NOG BESTAAN
			$this->keuzerichtingKlas_model->deleteAllWhereKlasID($klasId);

        	//ALLE PERSOON LESSEN SCHRAPPEN ALS DIE NOG BESTAAN
			$lessen = $this->les_model->getAllLesWhere($klasId);
			foreach ($lessen as $les){
				$this->persoonLes_model->deleteAllWhereLesID($les->id);
			}

			//ALLE LESSEN SCHRAPPEN ALS DIE NOG BESTAAN
			$this->les_model->deleteAllWhereKlasID($klasId);

			$this->klas_model->delete($klasId);

		}

		public function haalJsonOp_Mail(){
			$id = $this->input->get('mailId');

			$this->load->model("mail_model");
			$mail = $this->mail_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($mail);
		}

		public function haalJsonOp_Keuzerichting(){
			$id = $this->input->get('keuzerichtingId');

			$this->load->model('keuzerichting_model');
			$keuzerichting = $this->keuzerichting_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($keuzerichting);
		}

		public function haalJsonOp_Klas(){
			$id = $this->input->get('klasId');

			$this->load->model('klas_model');
			$klas = $this->klas_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($klas);
		}
    }
