<?php
    /**
     * @class Keuzerichting_model
     * @brief Model-klasse voor de keuzerichtingen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_keuzerichting
     * @property Persoon_model $persoon_model
     */
    class Keuzerichting_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Keuzerichting_model.php			 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Keuzerichting model    								 | \\
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
         * Retourneert het record met id=$id uit de tabel team22_keuzerichting
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('keuzerichting');
			return $query->row();
		}

		/**
		 * Voegt het record $keuzerichting toe aan de tabel team22_keuzerichting
		 * @param $keuzerichting het record dat toegevoegd wordt
		 * @return int id
		 */
		function insert($keuzerichting)
		{
			$this->db->insert('keuzerichting', $keuzerichting);
			return $this->db->insert_id();
		}

		/**
		 * Update het record $keuzerichting uit de tabel team22_keuzerichting
		 * @param $keuzerichting het record dat geüpdatet wordt
		 */
		function update($keuzerichting)
		{
			$this->db->where('id', $keuzerichting->id);
			$this->db->update('keuzerichting', $keuzerichting);
		}

		/**
		 * Delete een keuzerichting met $id = id uit de tabel team22_keuzerichting
		 * @param $id de id van het record dat verwijderd wordt
		 */
		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('keuzerichting');
		}

        /**
         * Retourneert alle records uit de tabel team22_keuzerichting
         * @return array met alle records
         */
		function getAll()
        {
            $query = $this->db->get('keuzerichting');
            return $query->result();
        }
    }
