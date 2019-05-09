<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class IspVerantwoordelijke
     * @brief Controllerklasse voor de ispverantwoordelijke
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de ispverantwoordelijke
     * @property Template $template
     * @property Persoon_model $persoon_model
     * @property Klas_model $klas_model
     * @property Vak_model $vak_model
     * @property Afspraak_model $afspraak_model
     * @property PersoonLes_model $persoonLes_model
     * @property Les_model les_model
     * @property  Excel $excel
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
			$this->load->model('les_model');
			$this->load->model('klas_model');
			$this->load->helper('plugin_helper');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','Tester','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('ispverantwoordelijke');

			// Gets plugins if required
			$data['plugins'] = getPlugin('table');

			$ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

			foreach ($ingediendeIspStudenten as $persoon){

                if($persoon->klasId == null) {
                    // Persoon zit niet in een klas -> persoonLessen ophalen
                    $persoon->persoonLessen = $this->persoonLes_model->getAllWithLesAndVakAndKlas($persoon->id);
					$persoon->klas = "Combi";
                } else {
                    // Persoon zit wel in een klas -> lessen van de klas ophalen
                    $persoon->persoonLessen = $this->les_model->getAllWithVakAndKlasWhereKlas($persoon->klasId);
                    $persoon->klas = $this->klas_model->get($persoon->klasId);

                }

				$persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);
			}

			$data['ingediendeIspStudenten'] = $ingediendeIspStudenten;


			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'IspVerantwoordelijke/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt alle klas-records op via Klas_model
         * en toont het resulterende object in de view klaslijsten.php
         * @see Klas_model::getAllKlassen()
         * @see klaslijsten.php
         */
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

        /**
         * Haalt de persoon-records met klasId=$klasId op via Persoon_model
         * en toont het resulterende object in de view ajax_klaslijsten
         * Deze view wordt via een ajax-call in klaslijsten.php geplaatst
         * @see Persoon_model::getAllWhereKlas()
         * @see Klas_model::get()
         * @see ajax_klaslijsten.php
         * @see klaslijsten.php
         */
        public function haalAjaxOp_Klassen()
        {
            $this->load->model('persoon_model');
            $this->load->model('klas_model');

            $klasId = $this->input->get('klasId');
            $klasOpties = array();

            $personen = $this->persoon_model->getAllWhereKlas($klasId);
            $data['personen'] = $personen;
            $klas = $this->klas_model->get($klasId);
            $data['klas'] = $klas;
            $klassen = $this->klas_model->getAllKlassen();
            foreach ($klassen as $klasOptie) {
                array_push($klasOpties, $klasOptie->naam);
            }
            $data['klassen'] = $klasOpties;

            $this->load->view('IspVerantwoordelijke/ajax_klaslijsten', $data);
        }

        /**
         * Haalt alle vak-records op via Vak_model
         * Haalt de persoon-records met ispIngediend=1 (en berekent het aantal opgenomen studiepunten) op via Persoon_model
         * en exporteert de resulterende objecten in een excel-document
         * @see Vak_model::getAll()
         * @see Persoon_model::getAllWhereIspIngediend()
         * @see PersoonLes_model::getAllWithLesAndVakAndKlas()
         * @see Les_model::getAllWithVakAndKlasWhereKlas()
         * @see Persoon_model::getStudiepunten()
         */
        public function documentExporteren() {
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');
            $this->load->library('excel');

            $this->load->model('vak_model');
            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');
            $this->load->model('les_model');

            // Variabelen
            $vakken = $this->vak_model->getAll();
            $ingediendeIspStudenten = $this->persoon_model->getAllWhereIspIngediend();

            // Configuratie van het bestand
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('ISP Export');
            $this->excel->getActiveSheet()->freezePane('C5');
            $bestandsnaam = 'isp-export-' . date('d-m-Y') . '.xlsx';

            // Opvullen van het bestand: HEADER
            $this->excel->getActiveSheet()->setCellValue('A1', 'ISP Export');
            $this->excel->getActiveSheet()->setCellValue('A2', date('d-m-Y'));
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('A4', 'Studentennummer');
            $this->excel->getActiveSheet()->setCellValue('B4', 'Naam');
            $this->excel->getActiveSheet()->setCellValue('C4', 'Aantal studiepunten');
            $this->excel->getActiveSheet()->setCellValue('D4', 'Advies');
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
            $this->excel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
            $this->excel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
            $this->excel->getActiveSheet()->getStyle('C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
            $this->excel->getActiveSheet()->getStyle('D4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
            foreach ($vakken as $vak) {
                $startColumn = PHPExcel_Cell::stringFromColumnIndex(3 + $vak->id);
                $this->excel->getActiveSheet()->setCellValue($startColumn . '4', $vak->naam);
                $this->excel->getActiveSheet()->getStyle($startColumn . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
                $this->excel->getActiveSheet()->getColumnDimension($startColumn)->setWidth(20);
            }

            // Opvullen van het bestand: INHOUD
            $startCell = 5;

            foreach ($ingediendeIspStudenten as $persoon) {
                if($persoon->klasId == null) {
                    // Persoon zit niet in een klas -> persoonLessen ophalen
                    $persoon->persoonLessen = $this->persoonLes_model->getAllWithLesAndVakAndKlas($persoon->id);
                } else {
                    // Persoon zit wel in een klas -> lessen van de klas ophalen
                    $persoon->persoonLessen = $this->les_model->getAllWithVakAndKlasWhereKlas($persoon->klasId);
                }

                $persoon->studiepunten = $this->persoon_model->getStudiepunten($persoon);

                $this->excel->getActiveSheet()->setCellValue('A' . $startCell, $persoon->nummer);
                $this->excel->getActiveSheet()->setCellValue('B' . $startCell, $persoon->naam);
                $this->excel->getActiveSheet()->setCellValue('C' . $startCell, $persoon->studiepunten);
                $this->excel->getActiveSheet()->setCellValue('D' . $startCell, $persoon->advies);

                foreach ($persoon->persoonLessen as $persoonLes) {
                    $startColumn = PHPExcel_Cell::stringFromColumnIndex(3 + $persoonLes->lesWithVak->vak->id);
                    $cellWaarde = $this->excel->getActiveSheet()->getCell($startColumn . $startCell)->getValue();
                    if($cellWaarde == null || $cellWaarde == '' || $cellWaarde == $persoonLes->lesWithVak->klas->naam) {
                        $this->excel->getActiveSheet()->setCellValue($startColumn . $startCell, $persoonLes->lesWithVak->klas->naam);
                    } else {
                        $this->excel->getActiveSheet()->setCellValue($startColumn . $startCell, $cellWaarde . ' & ' . $persoonLes->lesWithVak->klas->naam);
                    }
                }

                $startCell++;
            }

            // Browser bestand laten herkennen
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $bestandsnaam .'"');

            // Cachen van bestand voorkomen
            header('Cache-Control: max-age=0');

            // Excel2007 zorgt voor juiste bestandsindeling bij .xlsx extentie
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

            // Bestand direct downloaden zonder het op te slaan op de server
            $objWriter->save('php://output');
        }

        /**
         * Haalt een persoon-record waar het id overeenkomt via Persoon_model
         * Haalt alle persoonLes-records waar het persoonId overeenkomt en voegt lessen, klassen en vakken aan.
         * Haalt alle studiepunten op waar het id overeenkomt via Persoon_model.
         * Laad een ISP pagina van een student met details
         * @see Persoon_model::get()
         * @see PersoonLes_model::getAllWithLesAndVakAndKlas()
         * @see PersoonLes_model::getStudiepunten()
         * @see ISPDetails.php
         */
        public function toonISPDetails($studentid){

            $data['title'] = "Details ISP";

            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');

            $student = $this->persoon_model->get($studentid);
            $student->persoonLessen = $this->persoonLes_model->getAllWithLesAndVakAndKlas($student->id);
            $studiepunten = $this->persoon_model->getStudiepunten($student);

            $data['student'] = $student;
            $data['studiepunten'] = $studiepunten;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('ispverantwoordelijke');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'IspVerantwoordelijke/ISPDetails',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt de post student en bijhorend advies op uit de pagina en update deze in Persoon_model.
         * User wordt teruggestuurd naar index.
         * @see Persoon_model::update()
         * @see ispVerantwoordelijke/index.php
         */
        public function adviesOpslaan(){
            $this->load->model('persoon_model');

            if(isset($_POST['opslaan'])){
                $student = json_decode($this->input->post('student'));
                $student->advies = htmlspecialchars($this->input->post('advies'));
                $this->persoon_model->update($student);
            }

            redirect('ISPVerantwoordelijke/index');
        }

        /**
         * AJAX call voor een uurrooster van een combi-student op te halen.
         * @see ajax_uurroosterCombiSemester1.php
         * @see ajax_uurroosterCombiSemester2.php
         */
        public function haalAjaxOp_UurroosterCombi() {
            $semesterId = $this->input->get('semesterId');
            $data['studentId'] = $this->input->get('studentId');

            if($semesterId == 0){
                $this->load->view('IspVerantwoordelijke/ajax_uurroosterCombiSemester1', $data);
            }
            else{
                $this->load->view('IspVerantwoordelijke/ajax_uurroosterCombiSemester2', $data);
            }
        }

        /**
         * AJAX call voor lessen op te halen van een combi-student.
         * @see Les_model::getAllWhereStudentId()
         * @see Vak_model::get()
         */
        public function haalJsonOp_lessenPerStudent($studentId){
            $this->load->model('les_model');
            $this->load->model('vak_model');

            $lessen = $this->les_model->getAllWhereStudentId($studentId);

            foreach ($lessen as $les){
                $vak = $this->vak_model->get($les->vakId);
                $les->vaknaam = $vak->naam;
                $les->semester = $vak ->semester;
            }

            $this->output->set_content_type("application/json");
            echo json_encode($lessen);
        }

        /**
         * laad de kalender plugin en toont een kalender op de huidige week in de view overzichtAfspraken.php
         * @see overzichtAfspraken.php
         */
        public function afspraken(){
            $data['title'] = "Afspraken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar;
            $data['buttons'] = getNavbar('ispverantwoordelijke');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'IspVerantwoordelijke/overzichtAfspraken',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * haalt alle afspraken op in een ajax call en laad deze in de view overzichtAfspraken.php
         * @see Authex::getGebruikerInfo()
         * @see Afspraak_model::getAfsprakenWherePersoonIdDocent($persoonId)
         */
        public function haalAjaxop_AfsprakenDocent() {

            $this->load->model('afspraak_model');

            $persoonId = $this->authex->getGebruikerInfo();

            $data['afspraken'] = $this->afspraak_model->getAfsprakenWherePersoonIdDocent($persoonId->id);

            echo json_encode($data['afspraken']);
        }

        /**
         * Voegt een nieue vrije afspraak toe en herhaalt deze indien nodig
         * @see Authex::getGebruikerInfo()
         * @see Afspraak_model::addMoment($docentid, $startuur, $einduur, $datum, $plaats);
         */
        public function momentToevoegen() {
            $this->load->model('afspraak_model');

            $plaats = $this->input->get('plaats');
            $datum = $this->input->get('datum');
            $startuur = $this->input->get('start');
            $einduur = $this->input->get('end');
            $herhaal = $this->input->get('herhaal') + 1;

            $docent = $this->authex->getGebruikerInfo();

            for ($i = 1; $i <= $herhaal; $i++) {
                $this->afspraak_model->addMoment($docent->id, $startuur, $einduur, $datum, $plaats);
                $datum = strtotime($datum);
                $datum = strtotime("+7 day", $datum);
                $datum = date('Y-m-d', $datum);
            }
        }

        /**
         * past een afspraak aan
         * @see Afspraak_model::updateAfspraak($docentid, $startuur, $einduur, $datum, $plaats);
         */
        public function afspraakUpdate() {

            $this->load->model('afspraak_model');

            $id = $this->input->get('id');
            $plaats = $this->input->get('plaats');
            $datum = $this->input->get('datum');
            $startuur = $this->input->get('start');
            $einduur = $this->input->get('end');
            $description = $this->input->get('description');

            $this->afspraak_model->updateAfspraak($id, $startuur, $einduur, $datum, $plaats, $description);
        }

        /**
         * Verwijderd een afspraak ongeacht of deze al bezet is of vrij is
         * @see Afspraak_model::delete($id);
         */
        public function afspraakVerwijder() {
            $this->load->model('afspraak_model');

            $id = $this->input->get('id');

            $this->afspraak_model->delete($id);
        }

        /**
         * Maakt een bezette afspraak terug leeg en beschikbaar voor alle studenten
         * @see Afspraak_model::updateAfspraakBeschikbaarheid($id, $beschikbaar);
         */
        public function afspraakEmpty()
        {
            $this->load->model('afspraak_model');

            $id = $this->input->get('id');
            $beschikbaar = 1;

            $this->afspraak_model->updateAfspraakBeschikbaarheid($id, $beschikbaar);
        }

        /**
         * Haalt het persoon-record met id=$persoonId op via Persoon_model
         * en update de klasId van het resulterende object
         * @see Persoon_model::get($persoonId)
         * @see Persoon_model::update($persoon)
         */
        public function haalAjaxOp_WijzigKlas()
        {
            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');

            $persoonId = $this->input->get('persoonId');
            $klasId = $this->input->get('klasId');

            $persoon = $this->persoon_model->get($persoonId);
            $persoon->klasId = $klasId;
            $this->persoonLes_model->deletePersoonLesWherePersoonId($persoon->id);
            $this->persoon_model->update($persoon);
            $this->persoonLes_model->addPersoonLesWhereKlas($persoon);
        }
    }
