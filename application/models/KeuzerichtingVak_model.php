<?php
    /**
     * @property Persoon_model $persoon_model
     */
    class KeuzerichtingVak_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - KeuzerichtingVak_model.php		 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | KeuzerichtingVak model    								 | \\
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
			$query = $this->db->get('keuzerichtingVak');
			return $query->row();
		}

		function getAll()
        {
            $query = $this->db->get('keuzerichtingVak');
            return $query->result();
        }

        function getAllWithVakWhereKeuzerichting($keuzerichtingId)
        {
            $this->db->where('keuzerichtingId', $keuzerichtingId);
            $query = $this->db->get('keuzerichtingVak');
            $vakken = $query->result();

            $vakkenNieuw = array();

            foreach ($vakken as $vak)
            {
                $this->load->model('vak_model');
                $vakkenNieuw[$vak->keuzerichtingVakId] = $this->vak_model->get($vak->vakId);
            }

            return $vakkenNieuw;
        }







    }
