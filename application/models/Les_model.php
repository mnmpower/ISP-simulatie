<?php
    /**
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

        function __construct()
        {
            parent::__construct();
        }

        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('les');
            return $query->row();
        }



		function getWithVak($id)
		{
			$les = $this->get($id);

			//model laden + vak toevoegen
			$this->load->model('vak_model');
			$les->vak = $this->vak_model->get($les->vakId);
			return $les;
		}







    }
