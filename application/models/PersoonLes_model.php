<?php
    /**
     * @property Persoon_model $persoon_model
	 * @property Les_model $les_model
     */
    class PersoonLes_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - PersoonLes_model.php				 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | PersoonLes model 										 | \\
		// +---------------------------------------------------------+ \\
		// | T.Ingelaere, S. Kempeneer, J. Michiels, M. Michiels	 | \\
		// +---------------------------------------------------------+ \\

        function __construct()
        {
            parent::__construct();
        }

        function get($id)
        {
            $this->db->where('persoonLesId', $id);
            $query = $this->db->get('persoonLes');
            return $query->row();
        }



		function getAllWhere($persoonIdStudent){
			$this->db->where('persoonIdStudent',$persoonIdStudent);
			$query =$this->db->get('persoonLes');
			return  $query->result();
			//OK returnt alle persoonLESSEN van een persoonID
		}

		function getWithLesAndVak($persoonLesId){
        	$persoonLes = $this->get($persoonLesId);
        	//model laden + lesWithVak toevoegen
			$this->load->model('les_model');
        	$persoonLes->lesWithVak = $this->les_model->getWithVak($persoonLes->lesId);

        	return $persoonLes;
		}

		function getAllWithLesAndVak($persoonIdStudent){
        	$persoonLessen = $this->getAllWhere($persoonIdStudent);

			$this->load->model('les_model');


        	foreach ($persoonLessen as $persoonLes){
				$persoonLes->lesWithVak =  $this->les_model->getWithVak($persoonLes->lesId);
			}
			return $persoonLessen;
        	//OK Return alle persoonlessen met les en vak bij van een gegeven persoonID

		}




    }
