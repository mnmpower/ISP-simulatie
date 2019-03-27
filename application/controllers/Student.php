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

        public function setType(){
			$this->load->library('session');

			if(isset($_POST['model']) == "Model-student"){
				$this->session->set_userdata('type','model');
			}
			else if(isset($_POST['combi']) == "Combi-student"){
				$this->session->set_userdata('type','combi');
			}

			redirect('student/home_student');
		}

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
				redirect('Student/uurroosterWeergevenSemester1');
            }
            else if(isset($_POST['isp']))
            {
            }
        }

        public function uurroosterWeergevenSemester1(){
        	$this->load->model("klas_model");
			$data['title'] = "Uurrooster weergeven";
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('student');

			// Gets plugins if required
			$data['plugins'] = getPlugin('fullCalendar');

			$persoon = $this->authex->getGebruikerInfo();
			$klas = $this->klas_model->get($persoon->klasId);

			$data['klas'] = $klas;

        	$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Student/uurroosterWeergevenSemester1',
				'footer' => 'main_footer');
			$this->template->load('main_master', $partials, $data);
		}

		public function uurroosterWeergevenSemester2(){
			$this->load->model("klas_model");
			$data['title'] = "Uurrooster weergeven";
			// Defines roles for this page (You can also use "geen" or leave roles empty!).
			$data['roles'] = getRoles('ontwikkelaar','geen','geen','geen');

			// Gets buttons for navbar);
			$data['buttons'] = getNavbar('student');

			// Gets plugins if required
			$data['plugins'] = getPlugin('fullCalendar');

			$persoon = $this->authex->getGebruikerInfo();
			$klas = $this->klas_model->get($persoon->klasId);

			$data['klas'] = $klas;

			$partials = array(  'hoofding' => 'main_header',
				'inhoud' => 'Student/uurroosterWeergevenSemester2',
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
			echo json_encode($lessen);}

        public function klasvoorkeur()
        {
            $this->load->model('klas_model');

            $data['title'] = "Klasvoorkeur doorgeven";

            $klassen = $this->klas_model->getAllKlassen();
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

        public function voorkeurBevestigen(){

            $data['title'] = "Student";

            // Defines roles for this page (You can also use "geen" or leave roles empty!).
            $data['roles'] = getRoles('Tester','Ontwikkelaar','geen','geen');

            // Gets buttons for navbar);
            $data['buttons'] = getNavbar('student');

            // Gets plugins if required
            $data['plugins'] = getPlugin('geen');

            $persoon = $this->authex->getGebruikerInfo();

            $persoon->klasId = $this->input->post('klas');
            $this->load->model('klas_model');
            $this->persoon_model->update($persoon);

			$this->session->set_userdata('type','model');

            redirect('student/home_student');
        }

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

        public function haalAjaxOp_Vakken() {
            $keuzerichtingId = $this->input->get('keuzerichtingId');

            $this->load->model('keuzerichtingVak_model');
            $data['vakken'] = $this->keuzerichtingVak_model->getAllWithVakWhereKeuzerichting($keuzerichtingId);

            $this->load->view('student/ajax_jaarvakken', $data);
        }

        public function showAfspraakmaken() {
            $this->load->model('persoon_model');
            $this->load->model('persoonLes_model');
            $this->load->model('Les_model');

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
            $this->afspraak_model->updateAfspraak($description, $student->id, $id);
        }
    }
