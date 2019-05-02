<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Docent
     * @brief Controllerklasse voor de docent
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de docent
	 *
	 * @property Authex $authex
	 * @property Template $template
	 * @property Les_model $les_model
	 * @property Persoon_model $persoon_model
	 * @property Afspraak_model $afspraak_model
	 * @property PersoonLes_model $persoonLes_model
     */

    class Docent extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Docent.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Docent controller 										 | \\
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
            $this->load->helper('navbar_helper');
            $this->load->helper('plugin_helper');
			$this->load->helper('notation_helper');
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
			$this->load->model('les_model');
			$this->load->model('persoon_model');
			$this->load->model('persoonLes_model');

			$data['title'] = "Overzicht van de ingediende ISP simulaties";

			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','Tester','geen','geen');

			// Gets buttons for navbar;
			$data['buttons'] = getNavbar('docent');

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
				'inhoud' => 'Docent/index',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
        }

		/**
		 * laad de kalender plugin en toont een kalender op de huidige week in de view overzichtAfspraken.php
		 * @see overzichtAfspraken.php
		 */
        public function showAfspraken() {

            $data['title'] = "Overzicht van de ingediende ISP simulaties";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar;
            $data['buttons'] = getNavbar('docent');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Docent/overzichtAfspraken',
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
        public function afspraakEmpty() {
			$this->load->model('afspraak_model');

            $id = $this->input->get('id');
            $beschikbaar = 1;

            $this->afspraak_model->updateAfspraakBeschikbaarheid($id, $beschikbaar);
        }
    }
