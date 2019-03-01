<?php
    /**
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

        function __construct()
        {
            parent::__construct();
        }

		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('vak');
			return $query->row();
		}





    }
