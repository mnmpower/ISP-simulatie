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
         * Retourneert alle records uit de tabel team22_keuzerichting
         * @return Alle records
         */
		function getAll()
        {
            $query = $this->db->get('keuzerichting');
            return $query->result();
        }
    }
