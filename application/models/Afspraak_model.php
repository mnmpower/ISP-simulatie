<?php
/**
 * @property Afspraak_model $afspraak_model
 */

class Afspraak_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('afspraak');
        return $query->row();
    }

    function insert($afspraak)
    {
        $this->db->insert('afspraak', $afspraak);
        return $this->db->insert_id();
    }

    function update($afspraak)
    {
        $this->db->where('id', $afspraak->id);
        $this->db->update('mail', $afspraak);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('afspraak');
    }

    function getAfsprakenWherePersoonIdDocent($id){
        $this->db->where('persoonIdDocent', $id);
        $query = $this->db->get('afspraak');
        return $query->result();
    }
}