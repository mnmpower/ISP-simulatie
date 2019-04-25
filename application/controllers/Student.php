<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @class Student
     * @brief Controllerklasse voor de student
     *
     * Controller-klasse met alle methodes die gebruikt worden in de pagina's voor de student
     * @property Template $template
     * @property Klas_model $klas_model
     * @property Persoon_model $persoon_model
     * @property persoonLes_model $persoonLes_model
     * @property Afspraak_model $afspraak_model
     * @property Les_model $les_model
     * @property Vak_model $vak_model
     * @property Authex $authex
     */
    class Student extends CI_Controller
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Student.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Student controller 									 | \\
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
        }

        /**
         * Toont de view index.php
         * @see index.php
         */
        public function index()
        {
            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $partials = array(  'hoofding' => 'main_header',
                                'inhoud' => 'Student/index',
                                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Stopt het gekozen type student in een sessie
         */
        public function setType(){
			$this->load->library('session');

			if(isset($_POST['model']) == "Model-student"){
				$this->session->set_userdata('type','model');
			}
			else if(isset($_POST['combi']) == "Combi-student"){
				$this->session->set_userdata('type','combi');
			}

			redirect('Student/home_student');
		}

        /**
         * Toont de view horende bij het gekozen type student. Indien model-student: home_model en indien combi-student: home_combi
         * @see home_model.php
         * @see home_combi.php
         */
        public function home_student()
        {
			$this->load->library('session');
            $inhoud = '';
            $data['title'] = "Student";
//
            $typeStudent = $this->session->userdata("type");

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');


            if ($typeStudent == "model"){
            	$inhoud ='Student/home_model';

			}else if($typeStudent == "combi")
            {
				$inhoud ='Student/home_combi';			}

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => $inhoud,
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Vraagt de juist methode op afhankelijk van de keuze in het menu
         */
        public function keuzemenu()
        {
            if(isset($_POST['klasvoorkeur']))
            {
                redirect('Student/klasvoorkeur');
            }
            else if(isset($_POST['vakken']))
            {
                redirect('Student/toonJaarvakken');
            }
            else if(isset($_POST['afspraak']))
            {
                redirect('Student/showAfspraakmaken');
            }
            else if(isset($_POST['uurrooster']))
            {
				redirect('Student/uurroosterWeergeven');
            }
            else if(isset($_POST['isp2']))
            {
                redirect('Student/ispSamenstellen');
            }
        }

        /**
         * Haalt het klas-record met id=$persoon->klasId ( en het persoon-record via Authex)op via Klas_model
         * en toont het resulterende object in de view uurroosterWeergeven.php
         * @see Authex::getGebruikerInfo()
         * @see Klas_model::get($id)
         * @see uurroosterWeergeven.php
         */

        public function uurroosterWeergeven(){
        	$this->load->model("klas_model");
			$data['title'] = "Uurrooster weergeven";
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('Ontwikkelaar','geen','geen','Tester');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('student');

			// Gets plugins if required
			$data['plugins'] = getPlugin('fullCalendar');

			$persoon = $this->authex->getGebruikerInfo();
			$klas = $this->klas_model->get($persoon->klasId);

			$data['klas'] = $klas;

        	$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Student/uurroosterWeergeven',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}

		public function haalJsonOp_lessenPerKlas($klasId){
//			$klasId= $this->input->get('klasid');
        	$this->load->model('les_model');
        	$this->load->model('vak_model');

//			$data['lessen']= $this->les_model->getAllLesWhere($kladId);
			$lessen = $this->les_model->getAllLesWhere($klasId);

			foreach ($lessen as $les){
				$vak = $this->vak_model->get($les->vakId);
				$les->vaknaam = $vak->naam;
				$les->semester = $vak ->semester;
			}

			$this->output->set_content_type("application/json");
			echo json_encode($lessen);
		}

        /**
         * Haalt alle klas-records op via Klas_model
         * en toont het resulterende object in de view klasvoorkeur.php
         * @see Klas_model::getAllKlassen()
         * @see klasvoorkeur.php
         */
        public function klasvoorkeur()
        {
            $this->load->model('klas_model');

            $data['title'] = "Klasvoorkeur doorgeven";

            $klassen = $this->klas_model->getAllKlassenOrderByNaam();
            $data['klassen'] = $klassen;

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('Tester','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/klasvoorkeur',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt het persoon-record op via Authex
         * Update $persoon->klasId=$klasid via Persoon_model
         * @see Authex::getGebruikerInfo()
         * @see Persoon_model::update($persoon)
         */
        public function voorkeurBevestigen(){

            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('Tester','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $persoon = $this->authex->getGebruikerInfo();

            $klasId = $this->input->post('klas');
            $persoon->klasId = $klasId;
            $this->persoon_model->update($persoon);

			$this->session->set_userdata('type','model');

            redirect('Student/home_student');
        }

        /**
         * Haalt het klas-record met id=$klasId op via Klas_model
         * en toont het resulterende object in de view ajax_uurroosterSemester1.php indien $semesterId=0 of in de view ajax_uurroosterSemester2.php indien $semesterId=1
         * Deze view wordt via een ajax-call in klasvoorkeur.php geplaatst
         * @see Klas_model::get($id)
         * @see ajax_uurroosterSemester1.php
         * @see ajax_uurroosterSemester2.php
         * @see klasvoorkeur.php
         */
        public function haalAjaxOp_Uurrooster() {
            $klasId = $this->input->get('klasId');
            $semesterId = $this->input->get('semesterId');

            $this->load->model('klas_model');
            $klas = $this->klas_model->get($klasId);

            $data['klas'] = $klas;

            if($semesterId == 0){
                $this->load->view('Student/ajax_uurroosterSemester1', $data);
            }
            else{
                $this->load->view('Student/ajax_uurroosterSemester2', $data);
            }
        }

        /**
         * Haalt alle keuzerichting-records op via Keuzerichting_model
         * en toont het resulterende object in de view jaarvakken_raadplegen.php
         * @see Keuzerichting_model::getAll()
         * @see jaarvakken_raadplegen.php
         */
        public function toonJaarvakken()
        {
            $data['title'] = "Jaarvakken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','geen','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $this->load->model('keuzerichting_model');
            $data['keuzerichtingen'] = $this->keuzerichting_model->getAll();

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/jaarvakken_raadplegen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt de keuzerichtingVak-records met keuzerichtingId=$keuzerichtingId op via KeuzerichtingVak_model
         * en toont het resulterende object in de view ajax_jaarvakken
         * Deze view wordt via een ajax-call in jaarvakken_raadplegen.php geplaatst
         * @see KeuzerichtingVak_model::getAllWithVakWhereKeuzerichting()
         * @see ajax_jaarvakken.php
         * @see jaarvakken_raadplegen.php
         */
        public function haalAjaxOp_Vakken() {
            $keuzerichtingId = $this->input->get('keuzerichtingId');

            $this->load->model('keuzerichtingVak_model');
            $data['vakken'] = $this->keuzerichtingVak_model->getAllWithVakWhereKeuzerichting($keuzerichtingId);

            $this->load->view('Student/ajax_jaarvakken', $data);
        }

        /**
         * Haalt de persoon-records met typeId=2 of typeId=3 op via Persoon_model
         * en toont het resulterende object in de view afspraakMaken.php
         * @see Persoon_model::getDocentWhereTypeid($typeId, $typeId2)
         * @see afspraakMaken.php
         */
        public function showAfspraakmaken() {
            $this->load->model('persoon_model');

            $data['title'] = "Afspraak maken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','Tester');

            // Gets buttons for navbar;
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            // Data
            $data['docenten'] = $this->persoon_model->getDocentWhereTypeid(2,3);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/afspraakMaken',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxop_Afspraken() {
            $persoonId = $this->input->get('persoonId');

            $this->load->model('afspraak_model');
            $data['afspraken'] = $this->afspraak_model->getAfsprakenWherePersoonIdDocent($persoonId);

            echo json_encode($data['afspraken']);
        }

        public function afspraakToevoegen() {
            $this->load->library('session');
            $description = $this->input->get('description');

            $id = $this->input->get('id');
            $student = $this->authex->getGebruikerInfo();

            $this->load->model('afspraak_model');
            $this->afspraak_model->updateAfspraakReserveer($description, $student->id, $id);
        }

        public function ispSamenstellen(){
            $isp1 = array();
            $isp2 = array();
            $_SESSION['isp1'] = $isp1;
            $_SESSION['isp2'] = $isp2;

            $cookie_name = "walkthrough";
            if(!isset($_COOKIE[$cookie_name])) {
                $cookie_value = "aan";
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/team22/index.php/Student');
                header('Location: ' . $_SERVER['REQUEST_URI']);
            }

            $data['title'] = "ISP Samenstellen";
            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $this->load->model("klas_model");
            $data['klassen'] = $this->klas_model->getAllKlassen();

            $this->load->model("vak_model");
            $data['vakken'] = $this->vak_model->getAllWhereSemester(1, true);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/ispSamenstellen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function ispSamenstellen2(){
            $data['title'] = "ISP Samenstellen";
            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $this->load->model("klas_model");
            $data['klassen'] = $this->klas_model->getAllKlassen();

            $this->load->model("vak_model");
            $data['vakken'] = $this->vak_model->getAllWhereSemester(2, true);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/ispSamenstellen2',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function ispSamenstellenConfirm(){
            $data['title'] = "ISP Samenstellen";
            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/ispSamenstellenConfirm',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function haalAjaxOp_UurroosterPerKlas() {
            $klasId = $this->input->get('klasId');

            $this->load->model('les_model');
            $data['vakken'] = $this->les_model->getAllWithVakAndKlasWhereKlas($klasId);
            echo json_encode($data['vakken']);
        }

        public function haalAjaxOp_lesPerVak() {
            $vakId = $this->input->get('vakId');

            $this->load->model('les_model');
            $data['lessen'] = $this->les_model->getAllWithKlasWhereKlas($vakId);
            echo json_encode($data['lessen']);
        }

        public function haalAjaxOp_lesKlas() {
            $lessen = $this->input->get('lessen');
            $this->load->model('les_model');

            $data['rooster'] = $this->les_model->getAllWithVakAndKlasWhereLessen(json_decode($lessen));
            echo json_encode($data['rooster']);
        }

        public function sessions_lesKlas($lessen) {
            $this->load->model('les_model');

            $data['rooster'] = $this->les_model->getAllWithVakAndKlasWhereLessen(json_decode($lessen));
            echo json_encode($data['rooster']);
        }

        public function ispSubmit()
        {
            $student = $this->authex->getGebruikerInfo();
            $isp1 = str_replace('"', '', $this->input->get('isp1'));
            $isp1 = str_replace('[', '', $isp1);
            $isp1 = str_replace(']', '', $isp1);
            $isp1array = array_map('intval', explode(',', $isp1));

            $isp2 = str_replace('"', '', $this->input->get('isp2'));
            $isp2 = str_replace('[', '', $isp2);
            $isp2 = str_replace(']', '', $isp2);
            $isp2array = array_map('intval', explode(',', $isp2));
            $this->load->model('persoonLes_model');

            foreach ($isp1array as $les) {
                $this->persoonLes_model->addPersoonLes($les, $student->id);
            }

            foreach ($isp2array as $les) {
                $this->persoonLes_model->addPersoonLes($les, $student->id);
            }

            redirect('Student/home_student');
        }

        public function haalAjaxOp_ToggleCookie() {
            $cookie_name = "walkthrough";
            if ($_COOKIE[$cookie_name] == "aan"){
                $cookie_value = "uit";
            }
            else{
                $cookie_value = "aan";
            }
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/team22/index.php/Student');

        }
    }
