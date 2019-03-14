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
        $this->db->update('afspraak', $afspraak);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('afspraak');
    }

    function getAfsprakenWherePersoonIdDocent($id){
        $this->db->where('persoonIdDocent', $id);
        $query = $this->db->get('afspraak');
        $afspraken = $query->result();
        $this->load->model('persoon_model');

        foreach ($afspraken as $afspraak) {
            $afspraak->persoon =
                $this->persoon_model->getStudentnaam($afspraak->persoonIdStudent);
        }

        return $afspraken;
    }

    function updateAfspraak($description, $studentId, $id) {
        $data = array(
            'beschikbaar' => 0,
            'persoonIdStudent' => $studentId,
            'extraOpmerking' => $description
        );

        $this->db->where('id', $id);
        $this->db->update('afspraak', $data);
    }
}