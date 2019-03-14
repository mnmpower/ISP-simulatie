<?php
    /**
     * @class Vak_model
     * @brief Model-klasse voor de vakken
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_vak
     * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
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
         * @return Het opgevraagde record
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('vak');
			return $query->row();
		}
    }
