<?php
    /**
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

        function __construct()
        {
            parent::__construct();
        }

		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('klas');
			return $query->row();
		}







    }
