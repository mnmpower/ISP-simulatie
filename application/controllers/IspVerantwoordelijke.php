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
			$this->load->model('persoonLes_model');
			$this->load->model('vak_model');
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
			$data['buttons'] = getNavbar('ispverantwoordelijke');

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
         * @see ajax_klaslijsten.php
         * @see klaslijsten.php
         */
        public function haalAjaxOp_Klassen() {
            $klasId = $this->input->get('klasId');

            $this->load->model('klas_model');
            $personen = $this->persoon_model->getAllWhereKlas($klasId);
            $data['personen'] = $personen;
            $klas = $this->klas_model->get($klasId);
            $data['klas'] = $klas;


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
    }
