<?php
    /**
     * @class Klas_model
     * @brief Model-klasse voor de klassen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_klas
     * @property Persoon_model $persoon_model
     */
    class Klas_model extends CI_Model
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
         * Retourneert het record met id=$id uit de tabel team22_klas
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde klas record
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('klas');
			return $query->row();
		}

		/**
		 * Voegt het record $klas toe aan de tabel team22_Klas
		 * @param $klas het record dat toegevoegd wordt
		 * @return int id
		 */
		function insert($klas)
		{
			$this->db->insert('klas', $klas);
			return $this->db->insert_id();
		}

		/**
		 * Update het record $klas uit de tabel team22_Klas
		 * @param $klas het record dat geüpdatet wordt
		 */
		function update($klas)
		{
			$this->db->where('id', $klas->id);
			$this->db->update('klas', $klas);
		}

        /**
         * Retourneert alle klas records uit de tabel team22_Klas
         * @return array met alle klas records geordend op naam
         */
		function getAllKlassenOrderByNaam(){
			$this->db->order_by('naam');
            $query = $this->db->get('klas');

            return $query->result();
        }

		/**
		 * Retourneert alle klas records uit de tabel team22_Klas
		 * @return array met alle klas records
		 */
        function getAllKlassen(){
            $query = $this->db->get('klas');

            return $query->result();
        }

		/**
		 * Delete een klasrecord met $id = klasID uit de tabel team22_Klas
		 * @param $id de id van het record dat verwijderd wordt
		 */
		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('klas');
		}

        /**
         * Retourneert het record met naam=$naam uit de tabel team22_klas
         * @param $naam de naam van het record dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function getWhereNaam($naam)
        {
            $klassen = $this->getAllKlassen();
            foreach ($klassen as $klas) {
                $klasnaam = preg_replace("/[^A-Za-z0-9 ]/", '', $klas->naam);
                $klasnaam = str_replace(' ', '', $klasnaam);

                if(strtolower($klasnaam) == strtolower($naam)) {
                    return $klas;
                }
            }
        }
    }
