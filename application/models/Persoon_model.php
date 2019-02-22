<?php
    /**
     * @property Persoon_model $persoon_model
     */
    class Persoon_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Persoon_model.php					 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Persoon model 											 | \\
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
            $query = $this->db->get('persoon');
            return $query->row();
        }

		function insert($persoon)
		{
			$this->db->insert('persoon', $persoon);
			return $this->db->insert_id();
		}

        function update($persoon)
        {
            $this->db->where('id', $persoon->id);
            $this->db->update('persoon', $persoon);
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('persoon');
		}

    }
