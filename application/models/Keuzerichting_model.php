<?php
    /**
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

        function __construct()
        {
            parent::__construct();
        }

		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('keuzerichting');
			return $query->row();
		}

		function getAll()
        {
            $query = $this->db->get('keuzerichting');
            return $query->result();
        }

        function getAllWhereKeuzerichting($keuzerichtingId)
        {
            $this->db->where('keuzerichtingId', $keuzerichtingId);
            $query = $this->db->get('vak');
            return $query->result();
        }







    }
