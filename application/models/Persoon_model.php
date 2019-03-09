<?php
    /**
     * @property Persoon_model $persoon_model
	 * @property PersoonLes_model $persoonLes_model
     */
    class Persoon_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - Persoon_model.php					 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | Persoon model 											 | \\
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
            $query = $this->db->get('persoon');
            return $query->row();
        }

		function insert($persoon)
		{
			$this->db->insert('persoon', $persoon);
			return $this->db->insert_id();
		}

        function update($persoon)
        {
            $this->db->where('id', $persoon->id);
            $this->db->update('persoon', $persoon);
        }

		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('persoon');
		}

		function getAllWhereIspIngediend()
		{
			$this->db->where('ispIngediend', 1);
			$query = $this->db->get('persoon');
			return $query->result();
		}



		function getAllPersoonLesWithLesAndVak($persoon){

        	//model laden+ alle PersoonLessen toevoegen
			$this->load->model('persoonLes_model');

			$persoonLessen = $this->persoonLes_model->getAllWithLesAndVak($persoon->id);

			return $persoonLessen;
			//OK return alle persoonlessen per persoon
		}

		function getStudiepunten($persoonWithAllPersoonLesAndLesAndVak)
		{
			$studiepunten =0;

			foreach ($persoonWithAllPersoonLesAndLesAndVak->persoonLessen as $persoonLes){
				$studiepunten +=  $persoonLes->lesWithVak->vak->studiepunt;
			}
			return $studiepunten;
		}

		function getGebruiker($nummer, $wachtwoord) {
            $this->db->where('nummer', $nummer);
            $query = $this->db->get('persoon');

            if ($query->num_rows() == 1) {
                $persoon = $query->row();
                if(password_verify($wachtwoord, $persoon->wachtwoord)) {
                    return $persoon;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }

        function setWachtwoordWhereNummer($nummer, $secureGeneratedPassword) {
            $data = array('wachtwoord' => $secureGeneratedPassword);
            $this->db->where('nummer', $nummer);
            $this->db->update('persoon', $data);
        }

        function getAllWhereKlas($klasId){

            $this->db->where('klasId', $klasId);
            $query = $this->db->get('persoon');
            return $query->result();
        }

        function setKlasIdWhereNummer($nummer, $klasId) {
            $data = array('klasId' => $klasId);
            $this->db->where('nummer', $nummer);
            $this->db->update('persoon', $data);
        }
    }
