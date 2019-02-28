<?php
    /**
     * @property Persoon_model $persoon_model
	 * @property Les_model $les_model
     */
    class PersoonLes_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - PersoonLes_model.php				 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | PersoonLes model 										 | \\
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
            $query = $this->db->get('persoonLes');
            return $query->row();
        }

		function insert($persoonLes)
		{
			$this->db->insert('persoonLes', $persoonLes);
			return $this->db->insert_id();
		}

        function update($persoonLes)
        {
            $this->db->where('id', $persoonLes->id);
            $this->db->update('persoonLes', $persoonLes);
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('persoonLes');
		}

//		function getLes($persoonLes){
//			$this->db->where('lesId',$persoonLes->lesID);
//			$query =$this->db->get('les');
//			return $query->result();
//		}
		function getAllPersoonLes($persoon){
			$this->db->where('persoonIdStudent',$persoon->id);
			$query =$this->db->get('persoonLes');
			return $query->result();
		}




    }
