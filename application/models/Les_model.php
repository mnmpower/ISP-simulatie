<?php
    /**
     * @class Les_model
     * @brief Model-klasse voor de lessen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_les
	 * @property Persoon_model $persoon_model
	 * @property Vak_model $vak_model
     */
    class Les_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Les_model.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Les model 												 | \\
		// +---------------------------------------------------------+ \\
		// | T.Ingelaere, S. Kempeneer, J. Michiels, M. Michiels	 | \\
		// +---------------------------------------------------------+ \\
        /**
         * Constructor
         */
        function __construct()
        {
            parent::__construct();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_les
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('les');
            return $query->row();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_les en bijhorend record uit de tabel team22_vak
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde en bijhorende record
         */
		function getLesWithVak($id)
		{
			$les = $this->get($id);

			//model laden + vak toevoegen
			$this->load->model('vak_model');
			$les->vak = $this->vak_model->get($les->vakId);
			return $les;
		}

		/**
		 * Retourneert het record met id=$id uit de tabel team22_les en bijhorend record uit de tabel team22_vak
		 * @param $klasId is het id van de klas waar we alle lessen van willen opvragen
		 * @return alle less van een opgegeven klas
		 */
		function getAllLesWhere($klasId)
		{
			$this->db->where('klasId',$klasId);
			$query = $this->db->get('les');
			return $query->result();
		}

        /**
         * Retourneert alle records met klasId=$klasId uit de tabel team22_les en bijhorende records uit de tabel team22_vak en team22_klas
         * @param $klasId de klasId van de records  die opgevraagd worden
         * @return Array met alle opgevraagde records en bijhorende records
         */
        function getAllWithVakAndKlasWhereKlas($klasId){
            $this->db->where('klasId',$klasId);
            $query = $this->db->get('les');
            $persoonLessen = $query->result();

            $this->load->model('vak_model');
            $this->load->model('klas_model');

            foreach ($persoonLessen as $persoonLes){
                $persoonLes->lesWithVak = $this->getLesWithVak($persoonLes->id);
                $persoonLes->lesWithVak->klas = $this->klas_model->get($persoonLes->lesWithVak->klasId);
            }
            return $persoonLessen;
        }
    }
