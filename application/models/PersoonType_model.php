<?php
/**
 * @class PersoonType_model
 * @brief Model-klasse voor de persoonTypes
 * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_persoonType
 */
class PersoonType_model extends CI_Model
{

    // +---------------------------------------------------------+ \\
    // | ISP Project team22 - PersoonType_model.php				 | \\
    // +---------------------------------------------------------+ \\
    // | 2 ITF - 2018-2019										 | \\
    // +---------------------------------------------------------+ \\
    // | PersoonType model 			    						 | \\
    // +---------------------------------------------------------+ \\
    // | T.Ingelaere, S. Kempeneer, J. Michiels, M. Michiels	 | \\
    // +---------------------------------------------------------+ \\
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel team22_persoonType
     * @param $id de id van het record  dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('persoonType');
        return $query->row();
    }

    /**
     * Retourneert alle records uit de tabel team22_persoonType
     * @return Array met alle records
     */
    function getAll(){
        $query = $this->db->get('persoonType');
        return $query->result();
    }
}