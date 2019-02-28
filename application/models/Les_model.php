<?php
    /**
     * @property Persoon_model $persoon_model
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

		function insert($les)
		{
			$this->db->insert('les', $les);
			return $this->db->insert_id();
		}

        function update($Les)
        {
            $this->db->where('id', $Les->id);
            $this->db->update('les', $Les);
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('les');
		}







    }
