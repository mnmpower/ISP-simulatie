<?php

    class KeuzerichtingKlas_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - KeuzerichtingKlas_model.php		 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | KeuzerichtingKlas model    							 | \\
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

		function getAll()
        {
            $query = $this->db->get('keuzerichtingKlas');
            return $query->result();
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('keuzerichtingKlas');
		}

		function deleteAllWhereKeuzerichtingID($keuzerichtingId)
		{
			$this->db->where('keuzerichtingId', $keuzerichtingId);
			$this->db->delete('keuzerichtingKlas');
		}

		function deleteAllWhereKlasID($klasId)
		{
			$this->db->where('klasId', $klasId);
			$this->db->delete('keuzerichtingKlas');
		}
    }
