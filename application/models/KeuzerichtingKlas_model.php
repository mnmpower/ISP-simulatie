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

		/**
		 * Retourneert alle keuzerichtingKlas records uit de tabel team22_keuzerichtingKlas
		 * @return array met alle keuzerichtingKlas records
		 */
		function getAll()
        {
            $query = $this->db->get('keuzerichtingKlas');
            return $query->result();
        }

		/**
		 * Delete een keuzerichtingKlas met $id = keuzerichtingKlasID uit de tabel team22_keuzerichtingKlas
		 * @param $id de id van het record dat verwijderd wordt
		 */
		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('keuzerichtingKlas');
		}

		/**
		 * Delete de keuzerichtingKlas met $keuzerichtingId = keuzerichtingKlasID uit de tabel team22_keuzerichtingKlas
		 * @param $keuzerichtingId de id van het de keuzerichting waarvan dat alle records verwijderd worden
		 */
		function deleteAllWhereKeuzerichtingID($keuzerichtingId)
		{
			$this->db->where('keuzerichtingId', $keuzerichtingId);
			$this->db->delete('keuzerichtingKlas');
		}

		/**
		 * Delete de keuzerichtingKlas met $klasId = klasId uit de tabel team22_keuzerichtingKlas
		 * @param $klasId de id van het de klas waarvan dat alle records verwijderd worden
		 */
		function deleteAllWhereKlasID($klasId)
		{
			$this->db->where('klasId', $klasId);
			$this->db->delete('keuzerichtingKlas');
		}
    }
