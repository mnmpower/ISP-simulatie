<?php
    /**
     * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
     */
    class Vak_model extends CI_Model
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
			$query = $this->db->get('vak');
			return $query->row();
		}

		function insert($vak)
		{
			$this->db->insert('vak', $vak);
			return $this->db->insert_id();
		}

		function update($vak)
		{
			$this->db->where('id', $vak->id);
			$this->db->update('les', $vak);
		}

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('vak');
		}


    }
