<?php
    /**
     * @class KeuzerichtingVak_model
     * @brief Model-klasse voor de associatie tussen keuzerichtingen en vakken
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_keuzerichtingVak
     * @property Persoon_model $persoon_model
     * @property Vak_model $vak_model
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
        /**
         * Constructor
         */
        function __construct()
        {
            parent::__construct();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_keuzerichtingVak
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
		function get($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('keuzerichtingVak');
			return $query->row();
		}

        /**
         * Retourneert alle records uit de tabel team22_keuzerichtingVak
         * @return Alle records
         */
		function getAll()
        {
            $query = $this->db->get('keuzerichtingVak');
            return $query->result();
        }

        /**
         * Haalt alle records op met keuzerichtingId=$keuzerichtingId uit de tabel team22_keuzerichtingVak
         * Retourneert alle records met id=$vak->vakId uit de tabel team22_vak
         * @param $keuzerichtingId de keuzerichtingId van het record  dat opgevraagd wordt
         * @return Array met alle opgevraagde records
         */
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
