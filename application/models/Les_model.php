<?php
    /**
     * @class Les_model
     * @brief Model-klasse voor de lessen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_les
	 * @property Vak_model $vak_model
	 * @property Klas_model $klas_model
	 * @property Persoon_model $persoon_model
     * @property PersoonLes_model $persoonLes_model
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
         * Verwijdert het record met id=$id uit de tabel team22_les en het bijhoorde records in de tabel team22_persoonLes
         * @param $id de LesID van het record dat verwijderd wordt
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
         * Verwijdert alle records uit de tabel team22_les
         */
        function deleteAll()
        {
            $this->db->empty_table('les');
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
		 * @return array van lessen van een opgegeven klas
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
         * @return array met lessen, waar de bijhorende vakken en klassen zijn bijgevoegd.
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

		/**
		 * Delete het record $les uit de tabel team22_les
		 * @param $id de id van de les die verwijderd wordt
		 */
		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('les');
		}

		/**
		 * Delete alle lessen waarvan de  klasID =$klasId  uit de tabel team22_les
		 * @param $klasId de id van de klas waarvan een les moet zijn
		 */
		function deleteAllWhereKlasID($klasId)
		{
			$this->db->where('klasId', $klasId);
			$this->db->delete('les');
		}
		
        /**
         * Retourneert alle records  uit de tabel team22_les en bijhorende records uit de tabel team22_vak en team22_klas
         * @return array met alle lessen waar ook de vakken en klassen bij inzitten
         */
        function getAllWithVakAndKlas(){
            $query = $this->db->get('les');
            $lessen = $query->result();

            $this->load->model('vak_model');
            $this->load->model('klas_model');

            foreach ($lessen as $les){
                $les->vak = $this->vak_model->get($les->vakId);
                $les->klas = $this->klas_model->get($les->klasId);
                switch ($les->datum) {
                    case '2019-09-16':
                        $dag = 'Maadag';
                        break;
                    case '2019-09-17':
                        $dag = 'Dinsdag';
                        break;
                    case '2019-09-18':
                        $dag = 'Woensdag';
                        break;
                    case '2019-09-19':
                        $dag = 'Donderdag';
                        break;
                    case '2019-09-20':
                        $dag = 'Vrijdag';
                        break;
                }
                $les->dag = $dag;
                switch ($les->startuur) {
                    case '08:30:00':
                        if($les->einduur == '10:00:00') {
                            $blok = '1';
                        } else {
                            $blok = '1 & 2';
                        }
                        break;
                    case '10:15:00':
                        $blok = '2';
                        break;
                    case '12:30:00':
                        if($les->einduur == '14:00:00') {
                            $blok = '3';
                        } else {
                            $blok = '3 & 4';
                        }
                        break;
                    case '14:15:00':
                        $blok = '4';
                        break;
                    case '16:00:00':
                        $blok = '5';
                        break;
                }
                $les->blok = $blok;
            }
            return $lessen;
        }

        /**
         * Retourneert een les met id=$id uit de tabel team22_les en bijhorende records uit de tabel team22_vak en team22_klas
         * @param $id de id van de opgevraagde les
         * @return een les met bijhorend vak en een omgezette dag.
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

		/**
		 * Retourneert een array met lessen waarvan het vakID =$vakId it de tabel team22_vak en de bijhorende records uit team22_klas en team22_Vak
		 * @param $vakId de id van het vak waarvan alle lessen worden opgevraagd
		 * @return array met lessen met bijhorend vak en klas
		 */
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

		/**
		 * Retourneert alle lessen met hun vak en hun klas van een opgegeven array met lessen.
		 * @param $lessen is een array met lessen waar we extra informatie aan willen toevoegen
		 * @return array van lessen van een student waar een vak en een klas aan is toegevoegd
		 */
        function getAllWithVakAndKlasWhereLessen($lessen){
            $this->db->where_in('id', $lessen);
            $query = $this->db->get('les');
            $rooster = $query->result();

            $this->load->model('vak_model');
            $this->load->model('klas_model');

            foreach ($rooster as $les){
                $les->vak = $this->vak_model->get($les->vakId);
                $les->klas = $this->klas_model->get($les->klasId);
            }
            return $rooster;
        }

		/**
		 * Retourneert alle lessen van een persoon met ID=$studentId uit de tabel team22_les en bijhorend record uit de tabel team22_Les
		 * @param $studentId is het id van de persoon waar we alle lessen van willen opvragen
		 * @return array van lessen van een student
		 */
        function getAllWhereStudentId($studentId)
        {
            $result = array();
            $this->load->model('persoonLes_model');
            $persoonLessen = $this->persoonLes_model->getAllWherePersoonId($studentId);
            foreach ($persoonLessen as $persoonLes){
                $result1 = $result;
                $this->db->where('id',$persoonLes->lesId);
                $query = $this->db->get('les');
                $result2 = $query->result();
                $result = array_merge($result1, $result2);
            }
            return $result;
        }

        /**
         * Retourneert het record met klasId=$les->klasId, vakId=$les->vakId en datum=$vak->datum uit de tabel team22_les
         * @param $les het object met de les van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function getWhereKlasIdAndVakIdAndDatum($les)
        {
            $whereConditions = array('klasId' => $les->klasId, 'vakId' => $les->vakId, 'datum' => $les->datum);

            $this->db->where($whereConditions);
            $query = $this->db->get('les');
            //var_dump($query->num_rows);
            return $query->row();
        }

        /**
         * Retourneert alle records  uit de tabel team22_les
         * @return array met alle lessen
         */
        function getAll(){
            $query = $this->db->get('les');
            return $query->result();
        }
    }
