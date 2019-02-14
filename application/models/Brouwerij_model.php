<?php

    /**
     * @property Product_model $product_model
     */
    class Brouwerij_model extends CI_Model
    {

        // +----------------------------------------------------------
        // | Lekkerbier - Brouwerij_model
        // +----------------------------------------------------------
        // | 2 ITF - 2018-2019
        // +----------------------------------------------------------
        // | Brouwerij model
        // +----------------------------------------------------------
        // | M. Decabooter, J. Janssen
        // +----------------------------------------------------------

        function __construct()
        {
            parent::__construct();
        }

        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('bier_brouwerij');
            return $query->row();
        }

        function getAllByNaam()
        {
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_brouwerij');
            return $query->result();
        }


        function getWithProducten($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('bier_brouwerij');
            $brouwerij = $query->row();

            $this->load->model('product_model');
            $brouwerij->producten = $this->product_model->getAllByNaamWhereBrouwerij($brouwerij->id);

            return $brouwerij;
        }

		function getAllByNaamWithProducten()
		{
			$this->load->model('product_model');

			$this->db->order_by('naam', 'asc');
			$query1 = $this->db->get('bier_brouwerij');
			$brouwerijen = $query1->result();

			foreach ($brouwerijen as $brouwerij){
				$id = $brouwerij->id;
				$brouwerij->producten = $this->product_model->getAllByNaamWhereBrouwerij($id);
			}
			return $brouwerijen;
		}


		function insert($brouwerij)
        {
            $this->db->insert('bier_brouwerij', $brouwerij);
            return $this->db->insert_id();
        }

        function update($brouwerij)
        {
            $this->db->where('id', $brouwerij->id);
            $this->db->update('bier_brouwerij', $brouwerij);
        }

        function delete($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('bier_brouwerij');
        }

    }

?>
