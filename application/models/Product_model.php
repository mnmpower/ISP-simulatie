<?php

    /**
     * @property Soort_model $soort_model
     * @property Brouwerij_model $brouwerij_model
     */
    class Product_model extends CI_Model
    {

        // +----------------------------------------------------------
        // | Lekkerbier - Product_model
        // +----------------------------------------------------------
        // | 2 ITF - 2018-2019
        // +----------------------------------------------------------
        // | Product model
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
            $query = $this->db->get('bier_product');
            return $query->row();
        }

        function getAllByNaam()
        {
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_product');
            return $query->result();
        }

        function getAllByNaamWhereSoort($soortId)
        {
            $this->db->where('soortId', $soortId);
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_product');
            return $query->result();
        }

        function getAllByNaamWhereBrouwerij($brouwerijId)
        {
            $this->db->where('brouwerijId', $brouwerijId);
            $this->db->order_by('naam', 'asc');
            $query = $this->db->get('bier_product');
            return $query->result();
        }

        function getGekozenBiertjes($ids)
        {
            $producten = array();
            for ($i = 0; $i < count($ids); $i++) {
                $producten[$i] = $this->get($ids[$i]);
            }
            return $producten;
        }

        function getWithSoortEnBrouwerij($id)
        {
            $product = $this->get($id);

            $this->load->model('soort_model');
            $product->soort = $this->soort_model->get($product->soortId);

            $this->load->model('brouwerij_model');
            $product->brouwerij = $this->brouwerij_model->get($product->brouwerijId);

            return $product;
        }

        function delete($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('bier_product');
        }

        function deleteAllWhereSoort($soortId)
        {
            $this->db->where('soortId', $soortId);
            $this->db->delete('bier_product');
        }
    }

?>