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
     * @property PersoonType_model $persoonType_model
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
         * @see Klas_model::get()
         * @see index.php
         */
        public function index()
        {
			$this->load->model('persoon_model');
			$this->load->model('persoonLes_model');
			$this->load->model('Les_model');
			$this->load->model('Klas_model');
			$this->load->helper('plugin_helper');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','Tester','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('table');

			$ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

			foreach ($ingediendeIspStudenten as $persoon){

                if($persoon->klasId == null) {
                    // Persoon zit niet in een klas -> persoonLessen ophalen
                    $persoon->persoonLessen = $this->persoonLes_model->getAllWithLesAndVakAndKlas($persoon->id);
                } else {
                    // Persoon zit wel in een klas -> lessen van de klas ophalen
                    $persoon->persoonLessen = $this->les_model->getAllWithVakAndKlasWhereKlas($persoon->klasId);
					$persoon->klas = $this->klas_model->get($persoon->klasId);
				}

				$persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);
			}

			$data['ingediendeIspStudenten'] = $ingediendeIspStudenten;


			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Opleidingsmanager/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }

		/**
		 * Haalt alle gegevens op vor het beheermenu van de Opleidingsmanager
		 * @see beheermenu.php
		 */
        public function beheer()
        {
            $data['title'] = "Opleidingsmanager";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','Tester','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'opleidingsmanager/beheermenu',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

		/**
		 * Redirect door naar de justie pagina na het keizen van een beheerknop
		 * @see gebruikerBeheer.php
		 * @see klasBeheer.php
		 * @see lesBeheer.php
		 * @see mailBeheer.php
		 * @see keuzerichtingBeheer.php
		 */
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
            $data['roles'] = getRoles('geen','Ontwikkelaar','Tester','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $this->load->model('keuzerichting_model');

            $keuzerichtingen = $this->keuzerichting_model->getAll();
            $data['keuzerichtingen'] = $keuzerichtingen;

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Opleidingsmanager/vakBeheer',
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

		/**
		 * Een volle vak CRUD die mee keuzerichtigen vakken verwijderd en toevoegt
		 * @see Vak_model::insert
		 * @see Vak_model::update
		 * @see keuzerichtingVak_model::getAllWhereVak
		 * @see keuzerichtingVak_model::delete
		 * @see keuzerichtingVak_model::insert
		 * @see vakBeheer.php
		 */
        public function voegVakToe(){

            $this->load->model("vak_model");
            $this->load->model("keuzerichtingVak_model");
            $this->load->model("keuzerichting_model");

            $vakId = $this->input->post('vakId');

            $vak = new stdClass();
            $vak->id = $vakId;
            $vak->naam = htmlspecialchars($this->input->post("vakNaam"));
            $vak->studiepunt = $this->input->post("vakStudiepunten");
            $vak->fase = $this->input->post('fase2');
            $vak->semester = $this->input->post('semester');
            $vak->volgtijdelijkheidinfo = $this->input->post("vakOpmerking");
            $keuzerichtingen = $this->input->post('keuzerichtingcheckbox');


            if ($keuzerichtingen != null && $vak->studiepunt != 0) {
                if ($vak->id == 0) {
                    //nieuw record
                    $vakId = $this->vak_model->insert($vak);
                } else {
                    //bestaand record
                    $this->vak_model->update($vak);
                }


                $keuzerichtingVakken = $this->keuzerichtingVak_model->getAllWhereVak($vakId);

                foreach ($keuzerichtingVakken as $keuzerichtingVak) {
                    $this->keuzerichtingVak_model->delete($keuzerichtingVak->keuzerichtingVakId);
                }

                foreach ($keuzerichtingen as $keuzerichtingId) {
                    $keuzerichtingvak = new stdClass();
                    $keuzerichtingvak->keuzerichtingId = $keuzerichtingId;
                    $keuzerichtingvak->vakId = $vakId;
                    $this->keuzerichtingVak_model->insert($keuzerichtingvak);

                }
            }


            redirect('Opleidingsmanager/vakBeheer');
        }

		/**
		 * Delete een vak met bijhorend keuzerichtingvak
		 * @see keuzerichtingVak_model::getAllWhereVak
		 * @see Vak_model::update
		 * @see vak_model::delete
		 */
        public function schrapAjax_Vak() {
            $this->load->model("vak_model");
            $this->load->model("keuzerichtingVak_model");

            $vakId = $this->input->get('vakId');
            $keuzerichtingVakken = $this->keuzerichtingVak_model->getAllWhereVak($vakId);

            foreach ($keuzerichtingVakken as $keuzerichtingVak){
                $this->keuzerichtingVak_model->delete($keuzerichtingVak->keuzerichtingVakId);
            }
            $this->vak_model->delete($vakId);
        }

		/**
		 * Haalt een array met vakken van alle vakken met het zelfde keuzerichtingID
		 * @see vak_model::get
		 * @see keuzerichtingVak_model::getAllWhereVak
		 */
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

		/**
		 * laad de pagina voor gebruikers te beheren
		 * @see persoonType_model::getAll
		 * @see beheergebruikers.php
		 */
		public function gebruikerBeheer($foutmelding = NULL)
		{
            $data['title'] = "Gebruikers beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

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

		/**
		 * Haalt de gebruikers op voor een Ajax call toont niet de gebruiker met ID8, dit is een admin en mag niet verwijderd worden daarom dat deze niet mee wordt opgehaald
		 * @see persoon_model::getAllWithType
		 * @see ajax_gebruikers.php
		 */
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

		/**
		 * Haalt een gebruiker op voor een Ajax call met json en stuurt dit door
		 * @see persoon_model::get
		 */
        public function haalJsonOp_Gebruiker()
        {
            $id = $this->input->get('gebruikerId');

            $this->load->model('persoon_model');
            $object = $this->persoon_model->get($id);

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

		/**
		 * Schrapt een gebruiker
		 * @see persoon_model::delete
		 */
        public function schrapAjax_Gebruiker()
        {
            $gebruikerId = $this->input->get('gebruikerId');

            $this->load->model('persoon_model');
            $this->persoon_model->delete($gebruikerId);
        }

		/**
		 * controlleert of een gebruiker meermaals voorkomt of niet.
		 * @see persoon_model::getWhereNummer
		 */
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

		/**
		 * Voegteen gebruiker toe in de gebruikersCRUD
		 * @see persoon_model::getWhereNummer
		 * @see persoon_model::update
		 */
        public function voegGebruikerToe()
        {
            $object = new stdClass();
            $object->id = $this->input->post('gebruikerId');
            $object->naam = htmlspecialchars($this->input->post('gebruikerNaam'));
            $object->nummer = htmlspecialchars($this->input->post('gebruikerNummer'));
            $object->typeId = $this->input->post('gebruikerType');

            $this->load->model('persoon_model');
            if ($object->id == 0) {
                $gebruiker = $this->persoon_model->getWhereNummer($object->nummer);
                if (count($gebruiker) == 0) {
                    //nieuw record
                    $this->persoon_model->insert($object);
                }
            } else {
                //bestaand record
                $this->persoon_model->update($object);
            }

            redirect('Opleidingsmanager/gebruikerBeheer');
        }

		/**
		 * Laad een excel file in en leest deze uit
		 * @see persoon_model::deleteWhereType
		 * @see persoon_model::getWhereNummer
		 * @see persoon_model::insert
		 */
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

                    // Studenten verwijderen indien aangeduid
                    $deleteUsers = $this->input->post('deleteUsersExcel');
                    if($deleteUsers == true) {
                        $this->persoon_model->deleteWhereType(1);
                    }

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

		/**
		 * Laad de pagina om de lessen te beheren
		 * @see vak_model::getAll
		 * @see klas_model::getAllKlassenOrderByNaam
		 * @see beheerlessen.php
		 */
		public function lesBeheer($foutmelding = NULL)
        {
            $data['title'] = "Lessen beheren";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Tester','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('opleidingsmanager');

            // Gets plugins if required
            $data['plugins'] = getPlugin('table');

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

		/**
		 * Haalt de lessen op voor een Ajax call
		 * @see les_model::getAllWithVakAndKlas
		 * @see ajax_lessen.php
		 */
        public function haalAjaxOp_Lessen()
        {
			// Gets plugins if required
			$data['plugins'] = getPlugin('table');

            $this->load->model('les_model');
            $data['lessen'] = $this->les_model->getAllWithVakAndKlas();

            $this->load->view('opleidingsmanager/ajax_lessen', $data);
        }

		/**
		 * Haalt de Persoonlessen op voor een Ajax call in json formaat
		 * @see persoonLes_model::getAll
		 */
        public function haalJsonOp_PersoonLessen()
        {
            $this->load->model('persoonLes_model');
            $object = $this->persoonLes_model->getAll();

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

		/**
		 * Haalt de les op voor een Ajax call in json formaat
		 * @see les_model::getWithVakAndKlasAndDag
		 */
        public function haalJsonOp_Les()
        {
            $id = $this->input->get('lesId');

            $this->load->model('les_model');
            $object = $this->les_model->getWithVakAndKlasAndDag($id);

            $this->output->set_content_type("application/json");
            echo json_encode($object);
        }

		/**
		 * Schrapt een les
		 * @see les_model::delete
		 */
        public function schrapAjax_Les()
        {
            $lesId = $this->input->get('lesId');

            $this->load->model('persoonLes_model');
            $this->persoonLes_model->deleteWhereLes($lesId);

            $this->load->model('les_model');
            $this->les_model->delete($lesId);
        }

		/**
		 * Voegt een les toe
		 * @see les_model::insert
		 * @see les_model::update
		 */
        public function voegLesToe(){
            $object = new stdClass();
            $object->id = $this->input->post('lesId');
            $object->vakId = $this->input->post('lesVak');
            $object->klasId = $this->input->post('lesKlas');
            $dag = $this->input->post('lesDag');
            $object->startuur = $this->input->post('lesStartuur');
            $object->einduur = $this->input->post('lesEinduur');

            // Weekdag omzetten naar datum
            switch ($dag) {
                case 1:
                    $object->datum = '2019-09-16';
                    break;
                case 2:
                    $object->datum = '2019-09-17';
                    break;
                case 3:
                    $object->datum = '2019-09-18';
                    break;
                case 4:
                    $object->datum = '2019-09-19';
                    break;
                case 5:
                    $object->datum =  '2019-09-20';
                    break;
            }

            $this->load->model('les_model');
            if ($object->id == 0) {
                //nieuw record
                $this->les_model->insert($object);
            } else {
                //bestaand record
                $this->les_model->update($object);
            }

            redirect('Opleidingsmanager/lesBeheer');
        }

		/**
		 * Laad een excel file in en leest deze uit
		 * @see persoonLes_model::deleteAll
		 * @see les_model::deleteAll
		 * @see klas_model::getWhereNaam
		 */
        public function uploadLessenExcel() {
            $this->load->model('les_model');
            $this->load->model('persoonLes_model');
            $this->load->model('klas_model');

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'xlsx|xls';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excelFile'))
            {
                redirect('Opleidingsmanager/lesBeheer/fout');
            }
            else
            {
                // Alle persoonLessen verwijderen indien aangeduid
                $deletePersoonLessen = $this->input->post('deletePersoonLessenExcel');
                if($deletePersoonLessen == true) {
                    $this->persoonLes_model->deleteAll();
                }

                // Alle lessen verwijderen indien aangeduid
                $deleteLessen = $this->input->post('deleteLessenExcel');
                if($deleteLessen == true) {
                    $this->les_model->deleteAll();
                }

                $upload_data = $this->upload->data();
                $fileName = $upload_data['file_name'];
                $newName = 'lessen.xls';
                if(substr($fileName, -4) == "xlsx") {
                    $newName = "lessen.xlsx";
                }
                rename('./uploads/' . $fileName, './uploads/' . $newName);

                // Excel file koppelen
                $this->load->library('excel');
                $file = './uploads/' . $newName;
                $excelFile = PHPExcel_IOFactory::load($file);

                // Semester 1 inlezen
                $semester = $excelFile->getSheet(0)->getCell('A2')->getValue();
                $semester = str_replace(' ', '', $semester);
                if(strtolower($semester) == "semester1") {
                    // Teller init
                    $toegevoegd = 0;
                    $totaal = 0;

                    // Bestand inlezen
                    $row = 3;
                    $lastColumn = $excelFile->getSheet(0)->getHighestColumn();
                    $lastColumn++;
                    for ($column = 'A'; $column != $lastColumn; $column++) {
                        $cell_value = $excelFile->getSheet(0)->getCell($column.$row)->getValue();
                        if($cell_value != null) {
                            $klasnaam = preg_replace("/[^A-Za-z0-9 ]/", '', $cell_value);
                            $klasnaam = str_replace(' ', '', $klasnaam);

                            $lessen = new stdClass();
                            $klas = $this->klas_model->getWhereNaam($klasnaam);
                            $lessen->klas = $klas;

                            // Maandag
                            for($i = 4; $i <= 8; $i++) {
                                $blok = 'MA' . $excelFile->getSheet(0)->getCell('B' . $i)->getValue();
                                $lessen->$blok = $excelFile->getSheet(0)->getCell($column.$i)->getValue();

                                if ($excelFile->getSheet(0)->getCell($column.$i)->isInMergeRange()) {
                                    // Deel van een merged cell
                                    $mergeRange = $excelFile->getSheet(0)->getCell($column.$i)->getMergeRange();
                                    $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                    $lessen->$blok = $excelFile->getSheet(0)->getCell($masterCell)->getValue();;
                                }

                                $pos = strpos($lessen->$blok, ' of ');
                                if ($pos != false) {
                                    $origineel = $lessen->$blok;
                                    $lessen->$blok = substr($origineel, 0, $pos);
                                    $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                    if($this->addInDB($blokDubbel, 'maandag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }

                                if($lessen->$blok != null) {
                                    if($this->addInDB($this->renameForDB($lessen->$blok), 'maandag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }
                            }
                            // Dinsdag
                            for($i = 10; $i <= 14; $i++) {
                                $blok = 'DI' . $excelFile->getSheet(0)->getCell('B' . $i)->getValue();
                                $lessen->$blok = $excelFile->getSheet(0)->getCell($column.$i)->getValue();

                                if ($excelFile->getSheet(0)->getCell($column.$i)->isInMergeRange()) {
                                    // Deel van een merged cell
                                    $mergeRange = $excelFile->getSheet(0)->getCell($column.$i)->getMergeRange();
                                    $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                    $lessen->$blok = $excelFile->getSheet(0)->getCell($masterCell)->getValue();;
                                }

                                $pos = strpos($lessen->$blok, ' of ');
                                if ($pos != false) {
                                    $origineel = $lessen->$blok;
                                    $lessen->$blok = substr($origineel, 0, $pos);
                                    $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                    if($this->addInDB($blokDubbel, 'dinsdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }

                                if($lessen->$blok != null) {
                                    if($this->addInDB($this->renameForDB($lessen->$blok), 'dinsdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }
                            }
                            // Woensdag
                            for($i = 16; $i <= 20; $i++) {
                                $blok = 'WO' . $excelFile->getSheet(0)->getCell('B' . $i)->getValue();
                                $lessen->$blok = $excelFile->getSheet(0)->getCell($column.$i)->getValue();

                                if ($excelFile->getSheet(0)->getCell($column.$i)->isInMergeRange()) {
                                    // Deel van een merged cell
                                    $mergeRange = $excelFile->getSheet(0)->getCell($column.$i)->getMergeRange();
                                    $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                    $lessen->$blok = $excelFile->getSheet(0)->getCell($masterCell)->getValue();;
                                }

                                $pos = strpos($lessen->$blok, ' of ');
                                if ($pos != false) {
                                    $origineel = $lessen->$blok;
                                    $lessen->$blok = substr($origineel, 0, $pos);
                                    $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                    if($this->addInDB($blokDubbel, 'woensdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }

                                if($lessen->$blok != null) {
                                    if($this->addInDB($this->renameForDB($lessen->$blok), 'woensdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }
                            }
                            // Donderdag
                            for($i = 22; $i <= 26; $i++) {
                                $blok = 'DO' . $excelFile->getSheet(0)->getCell('B' . $i)->getValue();
                                $lessen->$blok = $excelFile->getSheet(0)->getCell($column.$i)->getValue();

                                if ($excelFile->getSheet(0)->getCell($column.$i)->isInMergeRange()) {
                                    // Deel van een merged cell
                                    $mergeRange = $excelFile->getSheet(0)->getCell($column.$i)->getMergeRange();
                                    $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                    $lessen->$blok = $excelFile->getSheet(0)->getCell($masterCell)->getValue();;
                                }

                                $pos = strpos($lessen->$blok, ' of ');
                                if ($pos != false) {
                                    $origineel = $lessen->$blok;
                                    $lessen->$blok = substr($origineel, 0, $pos);
                                    $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                    if($this->addInDB($blokDubbel, 'donderdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }

                                if($lessen->$blok != null) {
                                    if($this->addInDB($this->renameForDB($lessen->$blok), 'donderdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }
                            }
                            // Vrijdag
                            for($i = 28; $i <= 32; $i++) {
                                $blok = 'VR' . $excelFile->getSheet(0)->getCell('B' . $i)->getValue();
                                $lessen->$blok = $excelFile->getSheet(0)->getCell($column.$i)->getValue();

                                if ($excelFile->getSheet(0)->getCell($column.$i)->isInMergeRange()) {
                                    // Deel van een merged cell
                                    $mergeRange = $excelFile->getSheet(0)->getCell($column.$i)->getMergeRange();
                                    $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                    $lessen->$blok = $excelFile->getSheet(0)->getCell($masterCell)->getValue();;
                                }

                                $pos = strpos($lessen->$blok, ' of ');
                                if ($pos != false) {
                                    $origineel = $lessen->$blok;
                                    $lessen->$blok = substr($origineel, 0, $pos);
                                    $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                    if($this->addInDB($blokDubbel, 'vrijdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }

                                if($lessen->$blok != null) {
                                    if($this->addInDB($this->renameForDB($lessen->$blok), 'vrijdag', 1, $blok, $lessen->klas)) {
                                        $toegevoegd++;
                                    }
                                    $totaal++;
                                }
                            }
                        }
                    }

                    // Semester 2 inlezen
                    $semester = $excelFile->getSheet(1)->getCell('A1')->getValue();
                    $semester = str_replace(' ', '', $semester);
                    if(strtolower($semester) == "semester2") {
                        // Bestand inlezen
                        $row = 2;
                        $lastColumn = $excelFile->getSheet(1)->getHighestColumn();
                        $lastColumn++;
                        for ($column = 'A'; $column != $lastColumn; $column++) {
                            $cell_value = $excelFile->getSheet(1)->getCell($column.$row)->getValue();
                            if($cell_value != null) {
                                $klasnaam = preg_replace("/[^A-Za-z0-9 ]/", '', $cell_value);
                                $klasnaam = str_replace(' ', '', $klasnaam);

                                $lessen = new stdClass();
                                $klas = $this->klas_model->getWhereNaam($klasnaam);
                                $lessen->klas = $klas;

                                // Maandag
                                for($i = 3; $i <= 7; $i++) {
                                    $blok = 'MA' . $excelFile->getSheet(1)->getCell('B' . $i)->getValue();
                                    $lessen->$blok = $excelFile->getSheet(1)->getCell($column.$i)->getValue();

                                    if ($excelFile->getSheet(1)->getCell($column.$i)->isInMergeRange()) {
                                        // Deel van een merged cell
                                        $mergeRange = $excelFile->getSheet(1)->getCell($column.$i)->getMergeRange();
                                        $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                        $lessen->$blok = $excelFile->getSheet(1)->getCell($masterCell)->getValue();;
                                    }

                                    $pos = strpos($lessen->$blok, ' of ');
                                    if ($pos != false) {
                                        $origineel = $lessen->$blok;
                                        $lessen->$blok = substr($origineel, 0, $pos);
                                        $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                        if($this->addInDB($blokDubbel, 'maandag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }

                                    if($lessen->$blok != null) {
                                        if($this->addInDB($this->renameForDB($lessen->$blok), 'maandag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }
                                }
                                // Dinsdag
                                for($i = 9; $i <= 13; $i++) {
                                    $blok = 'DI' . $excelFile->getSheet(1)->getCell('B' . $i)->getValue();
                                    $lessen->$blok = $excelFile->getSheet(1)->getCell($column.$i)->getValue();

                                    if ($excelFile->getSheet(1)->getCell($column.$i)->isInMergeRange()) {
                                        // Deel van een merged cell
                                        $mergeRange = $excelFile->getSheet(1)->getCell($column.$i)->getMergeRange();
                                        $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                        $lessen->$blok = $excelFile->getSheet(1)->getCell($masterCell)->getValue();;
                                    }

                                    $pos = strpos($lessen->$blok, ' of ');
                                    if ($pos != false) {
                                        $origineel = $lessen->$blok;
                                        $lessen->$blok = substr($origineel, 0, $pos);
                                        $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                        if($this->addInDB($blokDubbel, 'dinsdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }

                                    if($lessen->$blok != null) {
                                        if($this->addInDB($this->renameForDB($lessen->$blok), 'dinsdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }
                                }
                                // Woensdag
                                for($i = 15; $i <= 19; $i++) {
                                    $blok = 'WO' . $excelFile->getSheet(1)->getCell('B' . $i)->getValue();
                                    $lessen->$blok = $excelFile->getSheet(1)->getCell($column.$i)->getValue();

                                    if ($excelFile->getSheet(1)->getCell($column.$i)->isInMergeRange()) {
                                        // Deel van een merged cell
                                        $mergeRange = $excelFile->getSheet(1)->getCell($column.$i)->getMergeRange();
                                        $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                        $lessen->$blok = $excelFile->getSheet(1)->getCell($masterCell)->getValue();;
                                    }

                                    $pos = strpos($lessen->$blok, ' of ');
                                    if ($pos != false) {
                                        $origineel = $lessen->$blok;
                                        $lessen->$blok = substr($origineel, 0, $pos);
                                        $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                        if($this->addInDB($blokDubbel, 'woensdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }

                                    if($lessen->$blok != null) {
                                        if($this->addInDB($this->renameForDB($lessen->$blok), 'woensdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }
                                }
                                // Donderdag
                                for($i = 21; $i <= 25; $i++) {
                                    $blok = 'DO' . $excelFile->getSheet(1)->getCell('B' . $i)->getValue();
                                    $lessen->$blok = $excelFile->getSheet(1)->getCell($column.$i)->getValue();

                                    if ($excelFile->getSheet(1)->getCell($column.$i)->isInMergeRange()) {
                                        // Deel van een merged cell
                                        $mergeRange = $excelFile->getSheet(1)->getCell($column.$i)->getMergeRange();
                                        $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                        $lessen->$blok = $excelFile->getSheet(1)->getCell($masterCell)->getValue();;
                                    }

                                    $pos = strpos($lessen->$blok, ' of ');
                                    if ($pos != false) {
                                        $origineel = $lessen->$blok;
                                        $lessen->$blok = substr($origineel, 0, $pos);
                                        $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                        if($this->addInDB($blokDubbel, 'donderdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }

                                    if($lessen->$blok != null) {
                                        if($this->addInDB($this->renameForDB($lessen->$blok), 'donderdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }
                                }
                                // Vrijdag
                                for($i = 27; $i <= 31; $i++) {
                                    $blok = 'VR' . $excelFile->getSheet(1)->getCell('B' . $i)->getValue();
                                    $lessen->$blok = $excelFile->getSheet(1)->getCell($column.$i)->getValue();

                                    if ($excelFile->getSheet(1)->getCell($column.$i)->isInMergeRange()) {
                                        // Deel van een merged cell
                                        $mergeRange = $excelFile->getSheet(1)->getCell($column.$i)->getMergeRange();
                                        $masterCell = substr($mergeRange, 0, strpos($mergeRange, ':'));
                                        $lessen->$blok = $excelFile->getSheet(1)->getCell($masterCell)->getValue();;
                                    }

                                    $pos = strpos($lessen->$blok, ' of ');
                                    if ($pos != false) {
                                        $origineel = $lessen->$blok;
                                        $lessen->$blok = substr($origineel, 0, $pos);
                                        $blokDubbel = $this->renameForDB(substr($origineel, $pos + 4, strlen($origineel)));
                                        if($this->addInDB($blokDubbel, 'vrijdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }

                                    if($lessen->$blok != null) {
                                        if($this->addInDB($this->renameForDB($lessen->$blok), 'vrijdag', 1, $blok, $lessen->klas)) {
                                            $toegevoegd++;
                                        }
                                        $totaal++;
                                    }
                                }
                            }
                        }

                        // Redirect naar overzicht gebruikers
                        redirect('Opleidingsmanager/lesBeheer/' . $toegevoegd . ' van de ' . $totaal);
                    } else {
                        redirect('Opleidingsmanager/lesBeheer/fout');
                    }
                } else {
                    redirect('Opleidingsmanager/lesBeheer/fout');
                }
            }
        }

		/**
		 * Hernoemt een aantal afkortingen zodat deze makkelijker in de database worden weggeschreven
		 * @return string
		 */
        public function renameForDB($string) {
            $vakAfkortingen = array(
                "po1" => "professioneleontwikkeling1",
                "po2" => "professioneleontwikkeling2",
                "po3" => "professioneleontwikkeling3"
            );

            $string = strtolower($string);
            $string = str_replace(' ', '', $string);
            $string = str_replace('evenweken', '', $string);
            $string = str_replace('onevenweken', '', $string);

            $pos = strpos($string, 'groep');
            if ($pos != false) {
                $string = substr($string, 0, $pos);
            }

            if(preg_match("/w+[1-99]+-/", $string, $matches, PREG_OFFSET_CAPTURE)) {
                $pos = $matches[0][1];
                $string = substr($string, 0, $pos);
            }

            if(isset($vakAfkortingen[$string])) {
                $string = $vakAfkortingen[$string];
            }

            return $string;
        }

		/**
		 * Voegt een vak toe in de database en return true of false om aan te geven of dit gelukt is
		 * @see vak_model::getIdWhereNaam
		 * @see les_model::getWhereKlasIdAndVakIdAndDatum
		 * @see les_model::insert
		 * @see les_model::update
		 * @return boolean
		 */
        public function addInDB($vak, $dag, $aantalBlokken, $startBlok, $klas) {
            $this->load->model('vak_model');
            $vakId = $this->vak_model->getIdWhereNaam($vak);

            if($vakId > 0) {
                $startBlok = substr($startBlok, 2, 1);
                $les = new stdClass();
                $les->klasId = $klas->id;
                $les->vakId = $vakId;
                switch ($dag){
                    case 'maandag':
                        $les->datum = '2019-09-16';
                        break;
                    case 'dinsdag':
                        $les->datum = '2019-09-17';
                        break;
                    case 'woensdag':
                        $les->datum = '2019-09-18';
                        break;
                    case 'donderdag':
                        $les->datum = '2019-09-19';
                        break;
                    case 'vrijdag':
                        $les->datum = '2019-09-20';
                        break;
                }
                switch ($startBlok){
                    case 1:
                        $les->startuur = '08:30:00';
                        $les->einduur = '10:00:00';
                        break;
                    case 2:
                        $les->startuur = '10:15:00';
                        $les->einduur = '11:45:00';
                        break;
                    case 3:
                        $les->startuur = '12:30:00';
                        $les->einduur = '14:00:00';
                        break;
                    case 4:
                        $les->startuur = '14:15:00';
                        $les->einduur = '15:45:00';
                        break;
                    case 5:
                        $les->startuur = '16:00:00';
                        $les->einduur = '17:30:00';
                        break;
                }

                $dubbelCheck = new stdClass();
                $dubbelCheck = $this->les_model->getWhereKlasIdAndVakIdAndDatum($les);
                if($dubbelCheck == null) {
                    $this->les_model->insert($les);
                } else {
                    if($dubbelCheck->klasId == $les->klasId && $dubbelCheck->vakId == $les->vakId && $dubbelCheck->datum == $les->datum) {
                        $les->id = $dubbelCheck->id;
                        $les->startuur = $dubbelCheck->startuur;

                        $this->les_model->update($les);
                    } else {
                        $this->les_model->insert($les);
                    }
                }
                return true;
            } else {
                return false;
            }
        }

		/**
		 *laad alles voorde pagina om mails te beheren
		 * @see mailBeheer.php
		 */
		public function mailBeheer()
		{
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','Tester','geen');

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

		/**
		 *laad alles voorde pagina om mails te beheren
		 * @see KeuzerichtingBeheer.php
		 */
		public function keuzerichtingBeheer()
		{
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','Tester');

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

		/**
		 *laad alles voorde pagina om mails te beheren
		 * @see KlasBeheer.php
		 */
		public function klasBeheer()
		{
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','Tester');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('opleidingsmanager');

			// Gets plugins if required
			$data['plugins'] = getPlugin('geen');

			$data['title'] = "Klassen beheren";

            $this->load->model('keuzerichting_model');
            $data['keuzerichtingen'] = $this->keuzerichting_model->getAll();

			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'opleidingsmanager/BeheerKlas/KlasBeheer',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}

		/**
		 * Haalt de lessen op voor een Ajax call
		 * @see mail_model::getAllMail
		 * @see ajax_MailCRUD.php
		 */
		public function haalAjaxOp_Mails(){

			$this->load->model('mail_model');
			$data['mails'] = $this->mail_model->getAllMail();

			$this->load->view('Opleidingsmanager/ajax_MailCRUD', $data);
		}

		/**
		 * Haalt de keuzerichtingen op voor een Ajax call
		 * @see keuzerichting_model::getAll
		 * @see ajax_KeuzerichtingCRUD.php
		 */
		public function haalAjaxOp_Keuzerichtingen(){
			$this->load->model('keuzerichting_model');
			$data['keuzerichtingen'] = $this->keuzerichting_model->getAll();

			$this->load->view('Opleidingsmanager/BeheerKeuzerichting/ajax_KeuzerichtingCRUD', $data);
		}

		/**
		 * Haalt de klassen op voor een Ajax call
		 * @see klas_model::getAllKlassenOrderByNaam
		 * @see ajax_KlasCRUD.php
		 */
		public function haalAjaxOp_Klassen(){
			$this->load->model('klas_model');
			$data['klassen'] = $this->klas_model->getAllKlassenOrderByNaam();

			$this->load->view('Opleidingsmanager/BeheerKlas/ajax_KlasCRUD', $data);
		}

		/**
		 * Voegt een mail toe of update deze en heeft een beveiligde encapsulation
		 * @see mail_model::insert
		 * @see mail_model::update
		 */
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

		/**
		 * Voegt een keuzerichting toe of update deze en heeft een beveiligde encapsulation
		 * @see keuzerichting_model::insert
		 * @see keuzerichting_model::update
		 */
		public function voegKeuzerichtingToe(){
			$this->load->model('keuzerichting_model');

			$keuzerichting = new stdClass();
			$keuzerichting->id = $this->input->post('KeuzerichtingId');
			$keuzerichting->naam = htmlspecialchars($this->input->post("KeuzerichtingNaam"));

			$keuzerichtingen = $this->keuzerichting_model->getAll();

			if ($keuzerichting->id == 0) {
				//nieuw record
				$this->keuzerichting_model->insert($keuzerichting);

			} else {
				//bestaand record
				$this->keuzerichting_model->update($keuzerichting);
			}
			redirect('Opleidingsmanager/keuzerichtingBeheer');
		}

		/**
		 * Voegt een klas toe of update deze en heeft een beveiligde encapsulation
		 * @see klas_model::insert
		 * @see klas_model::update
		 */
		public function voegKlasToe(){
			$this->load->model('klas_model');
			$this->load->model('keuzerichtingKlas_model');

			$klas = new stdClass();
			$klas->id = $this->input->post('klasId');
			$klas->naam = htmlspecialchars($this->input->post("klasNaam"));
			$klas->maximumAantal = htmlspecialchars($this->input->post("aantalLeerlingen"));
			$klas->maximumAantalModel = htmlspecialchars($this->input->post("aantalModel"));

            $keuzerichtingKlas = new stdClass();
            $keuzerichtingKlas->keuzerichtingKlasId = htmlspecialchars($this->input->post("keuzerichtingKlasId"));
            $keuzerichtingKlas->keuzerichtingId = htmlspecialchars($this->input->post("keuzerichting"));
            $keuzerichtingKlas->klasId = $klas->id;



            if ($klas->maximumAantal != 0 && $klas->maximumAantalModel != 0){
                if ($klas->id == 0) {
                    $klas->id = null;
                    //nieuw record
                    $klasId = $this->klas_model->insert($klas);
                    $keuzerichtingKlas->klasId = $klasId;
                    $this->keuzerichtingKlas_model->insert($keuzerichtingKlas);
                } else {
                    //bestaand record
                    $this->klas_model->update($klas);
                    $this->keuzerichtingKlas_model->update($keuzerichtingKlas);
                }
            }

			redirect('Opleidingsmanager/klasBeheer');
		}

		/**
		 * Schrapt een mail
		 * @see mail_model::delete
		 */
		public function schrapAjax_Mail() {
			$this->load->model("mail_model");

        	$mailId = $this->input->get('mailId');

        	$this->mail_model->delete($mailId);

		}

		/**
		 * Schrapt een Keuzerichting en alle bijhorende dingen zoals keuzerichtingvakken, keuzerichtingklassen en past personen van deze keuzerichting aan
		 * @see persoon_model::update
		 * @see keuzerichtingVak_model::deleteAllWhereKeuzerichtingID
		 * @see keuzerichtingKlas_model::deleteAllWhereKeuzerichtingID
		 * @see keuzerichting_model::delete
		 */
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

        	//ALLE KEUZERICHTING KLASSEN SCHRAPPEN ALS DIE NOG BESTAAN
			$this->keuzerichtingKlas_model->deleteAllWhereKeuzerichtingID($keuzerichtingId);

        	$this->keuzerichting_model->delete($keuzerichtingId);

		}

		/**
		 * Schrapt een klas en alle keuzerichtingenklassen, past de personen aan van deze klas, schrapt alle persoonlessen die tot deze klas behorenen ook alle lessen van deze klas
		 * @see persoon_model::getPersoonWhereKlasId
		 * @see persoon_model::update
		 * @see keuzerichtingKlas_model::getPersoonWhereKlasId
		 * @see les_model::getAllLesWhere
		 * @see persoonLes_model::deleteAllWhereLesID
		 * @see les_model::deleteAllWhereKlasID
		 * @see klas_model::delete
		 */
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

		/**
		 * Haalt de mail op voor een Ajax call in json formaat
		 * @see mail_model::get
		 */
		public function haalJsonOp_Mail(){
			$id = $this->input->get('mailId');

			$this->load->model("mail_model");
			$mail = $this->mail_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($mail);
		}

		/**
		 * Haalt de keuzerichting op voor een Ajax call in json formaat
		 * @see keuzerichting_model::get
		 */
		public function haalJsonOp_Keuzerichting(){
			$id = $this->input->get('keuzerichtingId');

			$this->load->model('keuzerichting_model');
			$keuzerichting = $this->keuzerichting_model->get($id);

			$this->output->set_content_type("application/json");
			echo json_encode($keuzerichting);
		}

		/**
		 * Haalt de klas op voor een Ajax call in json formaat
		 * @see klas_model::get
		 */
		public function haalJsonOp_Klas(){
			$id = $this->input->get('klasId');

			$this->load->model('klas_model');
			$this->load->model('keuzerichtingKlas_model');
			$this->load->model('keuzerichting_model');
			$klas = $this->klas_model->get($id);
			$klas->keuzerichtingKlas = $this->keuzerichtingKlas_model->getWhereKlas($id);
			$klas->keuzerichting = $this->keuzerichting_model->get($klas->keuzerichtingKlas->keuzerichtingId);

			$this->output->set_content_type("application/json");
			echo json_encode($klas);
		}

		/**
		 * Haalt het lege excel-sjabloon op en download het automatisch in de browser
         */
		public function downloadSjabloon() {
            redirect(base_url('assets/sjabloonStudenten.xlsx'));
        }
    }
