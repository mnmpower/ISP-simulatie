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
         * @return Het opgevraagde record
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('klas');
			return $query->row();
		}

		function insert($klas)
		{
			$this->db->insert('klas', $klas);
			return $this->db->insert_id();
		}

		/**
		 * Update het record $mail uit de tabel team22_mail
		 * @param $mail het record dat geüpdatet wordt
		 */
		function update($klas)
		{
			$this->db->where('id', $klas->id);
			$this->db->update('klas', $klas);
		}

        /**
         * Retourneert alle records uit de tabel team22_keuzerichtingVak
         * @return Alle records
         */
		function getAllKlassenOrderByNaam(){
			$this->db->order_by('naam');
            $query = $this->db->get('klas');

            return $query->result();
        }

        function getAllKlassen(){
            $query = $this->db->get('klas');

            return $query->result();
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('klas');
		}
    }
