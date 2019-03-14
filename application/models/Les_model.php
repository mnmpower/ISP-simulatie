<?php
    /**
     * @class Les_model
     * @brief Model-klasse voor de lessen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_les
	 * @property Persoon_model $persoon_model
	 * @property Vak_model $vak_model
     */
    class Les_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Les_model.php						 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Les model 												 | \\
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
         * Retourneert het record met id=$id uit de tabel team22_les
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('les');
            return $query->row();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_les en bijhorend record uit de tabel team22_vak
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde en bijhorende record
         */
		function getLesWithVak($id)
		{
			$les = $this->get($id);

			//model laden + vak toevoegen
			$this->load->model('vak_model');
			$les->vak = $this->vak_model->get($les->vakId);
			return $les;
		}
    }
