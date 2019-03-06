<?php

/**
 * @property Mail_model $mail_model
 */

class Mail_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('mail');
        return $query->row();
    }

    function insert($mail)
    {
        $this->db->insert('mail', $mail);
        return $this->db->insert_id();
    }

    function update($mail)
    {
        $this->db->where('id', $mail->id);
        $this->db->update('mail', $mail);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mail');
    }
}