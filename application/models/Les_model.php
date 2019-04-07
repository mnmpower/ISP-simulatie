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
         * Voegt het record $les toe aan de tabel team22_les
         * @param $les het record dat toegevoegd wordt
         * @return int id
         */
        function insert($les)
        {
            $this->db->insert('les', $les);
            return $this->db->insert_id();
        }

        /**
         * Update het record $les uit de tabel team22_les
         * @param $persoon het record dat geüpdatet wordt
         */
        function update($les)
        {
            $this->db->where('id', $les->id);
            $this->db->update('les', $les);
        }

        /**
         * Verwijdert het record met id=$id uit de tabel team22_les en het bijhoorde record in de tabel team22_persoonLes
         * @param $id de id van het record dat verwijderd wordt
         */
        function deleteWithPersoonLes($id)
        {
            // Verwijder bijhoordende persoonLessen
            $this->load->model('persoonLes_model');
            $this->persoonLes_model->deleteWhereLes($id);
            $this->db->where('id', $id);
            $this->db->delete('les');
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

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('les');
		}

		function deleteAllWhereKlasID($klasId)
		{
			$this->db->where('klasId', $klasId);
			$this->db->delete('les');
		}
        /**
         * Retourneert alle records  uit de tabel team22_les en bijhorende records uit de tabel team22_vak en team22_klas
         * @return Array met alle opgevraagde records en de bijhorende records
         */
        function getAllWithVakAndKlas(){
            $query = $this->db->get('les');
            $lessen = $query->result();

            $this->load->model('vak_model');
            $this->load->model('klas_model');

            foreach ($lessen as $les){
                $les->vak = $this->vak_model->get($les->vakId);
                $les->klas = $this->klas_model->get($les->klasId);
            }
            return $lessen;
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_les en bijhorende records uit de tabel team22_vak en team22_klas
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record en de bijhorende records
         */
        function getWithVakAndKlasAndDag($id)
        {
            $les = $this->get($id);

            $this->load->model('vak_model');
            $this->load->model('klas_model');

            $les->vak = $this->vak_model->get($les->vakId);
            $les->klas = $this->klas_model->get($les->klasId);

            // Datum omzetten naar weekdag
            switch ($les->datum) {
                case '2019-09-16':
                    $les->dag = 1;
                    break;
                case '2019-09-17':
                    $les->dag = 2;
                    break;
                case '2019-09-18':
                    $les->dag = 3;
                    break;
                case '2019-09-19':
                    $les->dag = 4;
                    break;
                case '2019-09-20':
                    $les->dag = 5;
                    break;
                default:
                    $les->dag = "";
                    break;
            }

            return $les;
        }

        function getAllWithKlasWhereKlas($vakId){
            $this->db->where('vakId',$vakId);
            $this->db->order_by("klasId", "asc");
            $query = $this->db->get('les');
            $lessen = $query->result();

            $this->load->model('klas_model');

            foreach ($lessen as $les){
                $les->klas = $this->klas_model->get($les->klasId);
            }
            return $lessen;
        }

    }
