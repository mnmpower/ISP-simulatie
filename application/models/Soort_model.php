<?php

    /**
     * @property Product_model $product_model
     */
    class Soort_model extends CI_Model
    {

        // +----------------------------------------------------------
        // | Lekkerbier - Soort_model
        // +----------------------------------------------------------
        // | 2 ITF - 201x-201x
        // +----------------------------------------------------------
        // | Soort model
        // |
        // +----------------------------------------------------------
        // | Thomas More Kempen
        // +----------------------------------------------------------

        function __construct()
        {
            parent::__construct();
        }

        function delete($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('bier_soort');
        }

        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('bier_soort');
            return $query->row();
        }

        function getAllByNaam()
        {
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_soort');
            return $query->result();
        }

        function getAllWithProducten()
        {
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_soort');
            $soorten = $query->result();

            $this->load->model('product_model');

            foreach ($soorten as $soort) {
                $soort->producten =
                    $this->product_model->getAllByNaamWhereSoort($soort->id);
            }
            return $soorten;
        }

        function getWhereNaam($soortnaam)
        {
            $this->db->where('naam', $soortnaam);
            $query = $this->db->get('bier_soort');
            return $query->row();
        }

        function insert($soort)
        {
            $this->db->insert('bier_soort', $soort);
            return $this->db->insert_id();
        }

        function update($soort)
        {
            $this->db->where('id', $soort->id);
            $this->db->update('bier_soort', $soort);
        }
    }

?>