<?php
    /**
     * @class Vak_model
     * @brief Model-klasse voor de vakken
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_vak
     * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
     * @property KeuzerichtingVak_model $keuzerichtingVak_model
     */
    class Vak_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Vak_model.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Vak model 												 | \\
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
         * Retourneert het record met id=$id uit de tabel team22_vak
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde vak
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('vak');
			return $query->row();
		}

        /**
         * Retourneert alle records uit de tabel team22_vak
         * @return Alle records
         */
        function getAll()
        {
            $query = $this->db->get('vak');
            return $query->result();
        }

        /**
         * Haalt alle records op met keuzerichtingId=$keuzerichtingId uit de tabel team22_keuzerichtingVak
         * Retourneert alle records met id=$vak->vakId en fase=$faseIduit de tabel team22_vak
         * @param $keuzerichtingId de keuzerichtingId van het record  dat opgevraagd wordt
         * @param $faseId de fase van het record  dat opgevraagd wordt
         * @return Array met alle opgevraagde records
         */
        function getAllWhereKeuzerichtingAndFase($keuzerichtingId, $faseId)
        {
            $this->load->model('keuzerichtingVak_model');

            $vakken = $this->keuzerichtingVak_model->getAllWithVakWhereKeuzerichting($keuzerichtingId);

            $this->db->where('fase', $faseId);
            $id_array = array();
            foreach ($vakken as $vak){
                array_push($id_array, $vak->id);
            }
            $this->db->where_in('id', $id_array);
            $query = $this->db->get('vak');;
            return $query->result();
        }

        /**
         * Voegt het record $vak toe aan de tabel team22_vak
         * @param $vak het record dat toegevoegd wordt
         * @return int id
         */
        function insert($vak)
        {
            $this->db->insert('vak', $vak);
            return $this->db->insert_id();
        }

        /**
         * Update het record $vak uit de tabel team22_vak
         * @param $vak het record dat geüpdatet wordt
         */
        function update($vak)
        {
            $this->db->where('id', $vak->id);
            $this->db->update('vak', $vak);
        }

        /**
         * Verwijdert het record met id=$id uit de tabel team22_vak
         * @param $id de id van het record dat verwijderd wordt
         */
        function delete($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('vak');
        }

		/**
		 * Retourneert alle records van de vakken van het opgevraagde semester.
		 * @param $semester is het semester waarin het vak gegeven moet worden.
		 * @param $both een boolean om te kijken of jaarvakken ook worden weergegeven of niet.
		 * @return de opgevraagde vakken van een semester
		 */
        function getAllWhereSemester($semester, $both)
        {
            $this->db->where('semester', $semester);
            if ($both == true) {
                $this->db->or_where('semester', 3);
            }
            $query = $this->db->get('vak');
            return $query->result();
        }
    }
