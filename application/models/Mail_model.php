<?php

/**
 * @class Mail_model
 * @brief Model-klasse voor de mails
 * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_mail
 * @property Mail_model $mail_model
 */

class Mail_model extends CI_Model
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel team22_mail
     * @param $id de id van het record  dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('mail');
        return $query->row();
    }

    /**
     * Voegt het record $mail toe aan de tabel team22_mail
     * @param $mail het record dat toegevoegd wordt
     * @return int id
     */
    function insert($mail)
    {
        $this->db->insert('mail', $mail);
        return $this->db->insert_id();
    }

    /**
     * Update het record $mail uit de tabel team22_mail
     * @param $mail het record dat geüpdatet wordt
     */
    function update($mail)
    {
        $this->db->where('id', $mail->id);
        $this->db->update('mail', $mail);
    }

    /**
     * Verwijdert het record met id=$id uit de tabel team22_mail
     * @param $id de id van het record dat verwijderd wordt
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mail');
    }

	/**
	 * Retourneert alle records uit de tabel team22_mail
	 * @return array met alle mails
	 */
    function getAllMail(){
		$query = $this->db->get('mail');
		return $query->result();
	}
}
