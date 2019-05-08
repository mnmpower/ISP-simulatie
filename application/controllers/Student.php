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
     * @property PersoonLes_model $persoonLes_model
     * @property Afspraak_model $afspraak_model
     * @property Les_model $les_model
     * @property Vak_model $vak_model
     * @property Keuzerichting_model $keuzerichting_model
     * @property KeuzerichtingVak_model $keuzerichtingVak_model
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
        }

        /**
         * Toont de view index.php
         * @see index.php
         */
        public function index()
        {
            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','Ontwikkelaar','Tester','geen');

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
        public function setType()
        {
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
            $data['roles'] = getRoles('geen','Ontwikkelaar','Tester','geen');

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
        public function uurroosterWeergeven()
        {
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


        /**
         * Haalt alle les-records met klasId=$klasId op via Les_model
         * en de bijhorende vak-records met id=$klasId op via Les_model
         * @see Les_model::getAllLesWhere($klasid)
         * @see Vak_model::get($les->vakId)
         */
		public function haalJsonOp_lessenPerKlas($klasId)
        {
        	$this->load->model('les_model');
        	$this->load->model('vak_model');

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
         * @see Klas_model::getAllKlassenOrderByNaam()
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
         * en update klasId=$klasid via Persoon_model
         * @see Authex::getGebruikerInfo()
         * @see Persoon_model::update($persoon)
         */
        public function voorkeurBevestigen()
        {
            $this->load->model('persoon_model');
            $this->load->library('session');

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
        public function haalAjaxOp_Uurrooster()
        {
            $this->load->model('klas_model');

            $klasId = $this->input->get('klasId');
            $semesterId = $this->input->get('semesterId');

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
            $this->load->model('keuzerichting_model');

            $data['title'] = "Jaarvakken";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Tester','Ontwikkelaar');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

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
        public function haalAjaxOp_Vakken()
        {
            $this->load->model('keuzerichtingVak_model');

            $keuzerichtingId = $this->input->get('keuzerichtingId');

            $data['vakken'] = $this->keuzerichtingVak_model->getAllWithVakWhereKeuzerichting($keuzerichtingId);

            $this->load->view('Student/ajax_jaarvakken', $data);
        }

        /**
         * Haalt de persoon-records met typeId=2 of typeId=3 op via Persoon_model
         * en toont het resulterende object in de view afspraakMaken.php
         * @see Persoon_model::getDocentWhereTypeid($typeId, $typeId2)
         * @see afspraakMaken.php
         */
        public function showAfspraakmaken()
        {
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

        /**
         * Haalt alle afspraak-records met persoonIdDocent=$persoonId op via Afspraak_model en geeft deze door aan Student_afspraakMaken.js
         * @see Afspraak_model::getAfsprakenWherePersoonIdDocent($persoonId)
         */
        public function haalAjaxop_Afspraken()
        {
            $this->load->model('afspraak_model');

            $persoonId = $this->input->get('persoonId');

            $data['afspraken'] = $this->afspraak_model->getAfsprakenWherePersoonIdDocent($persoonId);

            echo json_encode($data['afspraken']);
        }

        /**
         * Reserveert een afspraak voor de ingelogde student
         * @see Authex::getGebruikerInfo()
         * @see Afspraak_model::updateAfspraakReserveer()
         */
        public function afspraakToevoegen()
        {
            $this->load->library('session');
            $this->load->model('afspraak_model');

            $description = $this->input->get('description');

            $id = $this->input->get('id');
            $student = $this->authex->getGebruikerInfo();

            $this->afspraak_model->updateAfspraakReserveer($description, $student->id, $id);
        }

        /**
         * Haalt alle klas-records op via Klas_model en alle vakrecords met semester=1 of semester=3 op via Vak_model
         * en toont het resulterende object in de view ispSamenstellen.php
         * @see Klas_model::getAllKlassen()
         * @see Vak_model::getAllWhereSemester(1, true)
         * @see ispSamenstellen.php
         */
        public function ispSamenstellen()
        {
            $this->load->library('session');
            $this->load->model("klas_model");
            $this->load->model("vak_model");

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

            $data['klassen'] = $this->klas_model->getAllKlassen();
            $data['vakken'] = $this->vak_model->getAllWhereSemester(1, true);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/ispSamenstellen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Haalt alle klas-records op via Klas_model en alle vakrecords met semester=2 of semester=3 op via Vak_model
         * en toont het resulterende object in de view ispSamenstellen.php
         * @see Klas_model::getAllKlassen()
         * @see Vak_model::getAllWhereSemester(2, true)
         * @see ispSamenstellen.php
         */
        public function ispSamenstellen2()
        {
            $this->load->model("klas_model");
            $this->load->model("vak_model");

            $data['title'] = "ISP Samenstellen";
            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('geen','geen','Ontwikkelaar','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('fullCalendar');

            $data['klassen'] = $this->klas_model->getAllKlassen();
            $data['vakken'] = $this->vak_model->getAllWhereSemester(2, true);

            $partials = array(  'hoofding' => 'main_header',
                'inhoud' => 'Student/ispSamenstellen2',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        /**
         * Toont de vooraf samengestelde uurroosters in de view ispSamenstellenConfirm.php
         * @see ispSamenstellenConfirm.php
         */
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

        /**
         * Haalt alle les-records met klasId=$klasId met bijhorend vak- en klas-record op via Les_model en geeft deze door aan ispSamenstellen.js
         * @see Les_model::getAllWithVakAndKlasWhereKlas($klasId)
         */
        public function haalAjaxOp_UurroosterPerKlas()
        {
            $this->load->model('les_model');

            $klasId = $this->input->get('klasId');

            $data['vakken'] = $this->les_model->getAllWithVakAndKlasWhereKlas($klasId);
            echo json_encode($data['vakken']);
        }

        /**
         * Haalt alle les-records met vakId=$vakId met bijhorend klas-record op via Les_model en geeft deze door aan ispSamenstellen.js
         * @see Les_model::getAllWithKlasWhereKlas($vakId)
         */
        public function haalAjaxOp_lesPerVak()
        {
            $this->load->model('les_model');

            $vakId = $this->input->get('vakId');

            $data['lessen'] = $this->les_model->getAllWithKlasWhereKlas($vakId);
            echo json_encode($data['lessen']);
        }

        /**
         * Haalt alle les-records van de meegegeven lessen met bijhorend vak- en klas-record op via Les_model en geeft deze door aan ispSamenstellen.js
         * @see Les_model::getAllWithVakAndKlasWhereLessen($lessen)
         */
        public function haalAjaxOp_lesKlas()
        {
            $this->load->model('les_model');

            $lessen = $this->input->get('lessen');

            $data['rooster'] = $this->les_model->getAllWithVakAndKlasWhereLessen(json_decode($lessen));
            echo json_encode($data['rooster']);
        }

        /**
         * Haalt alle les-records van de meegegeven lessen met bijhorend vak- en klas-record op via Les_model
         * @see Les_model::getAllWithVakAndKlasWhereLessen($lessen)
         */
        public function sessions_lesKlas($lessen)
        {
            $this->load->model('les_model');

            $data['rooster'] = $this->les_model->getAllWithVakAndKlasWhereLessen(json_decode($lessen));
            echo json_encode($data['rooster']);
        }

        /**
         * Voegt alle persoonlessen van de ingevulde ISP toe aan de database via PersoonLes_model
         * @see Authex::getGebruikerInfo()
         * @see PersoonLes_model::addPersoonLes()
         */
        public function ispSubmit()
        {
            $this->load->model('persoonLes_model');

            $student = $this->authex->getGebruikerInfo();
            $isp1 = str_replace('"', '', $this->input->get('isp1'));
            $isp1 = str_replace('[', '', $isp1);
            $isp1 = str_replace(']', '', $isp1);
            $isp1array = array_map('intval', explode(',', $isp1));

            $isp2 = str_replace('"', '', $this->input->get('isp2'));
            $isp2 = str_replace('[', '', $isp2);
            $isp2 = str_replace(']', '', $isp2);
            $isp2array = array_map('intval', explode(',', $isp2));

            foreach ($isp1array as $les) {
                $this->persoonLes_model->addPersoonLes($les, $student->id);
            }

            foreach ($isp2array as $les) {
                $this->persoonLes_model->addPersoonLes($les, $student->id);
            }

            redirect('Student/home_student');
        }

        /**
         * Wijzigt de cookie-waarde om de walkthrough aan of af te zetten
         */
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
