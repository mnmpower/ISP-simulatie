<?php
    /**
     * @class Persoon_model
     * @brief Model-klasse voor de personen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_persoon
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
        /**
         * Constructor
         */
        function __construct()
        {
            parent::__construct();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_persoon
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function get($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('persoon');
            return $query->row();
        }

      /**
       * Voegt het record $persoon toe aan de tabel team22_persoon
       * @param $persoon het record dat toegevoegd wordt
       * @return int id
       */
		function insert($persoon)
		{
			$this->db->insert('persoon', $persoon);
			return $this->db->insert_id();
		}

        /**
         * Update het record $persoon uit de tabel team22_persoon
         * @param $persoon het record dat geüpdatet wordt
         */
        function update($persoon)
        {
            $this->db->where('id', $persoon->id);
            $this->db->update('persoon', $persoon);
        }

        /**
         * Verwijdert het record met id=$id uit de tabel team22_persoon
         * @param $id de id van het record dat verwijderd wordt
         */
		function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('persoon');
		}

        /**
         * Retourneert alle records met id=$id uit de tabel team22_persoon
         * @return Array met alle opgevraagde records
         */
		function getAllWhereIspIngediend()
		{
			$this->db->where('ispIngediend', 1);
			$query = $this->db->get('persoon');
			return $query->result();
		}

		/**
		 * @brief Om de studiepunten te berekenen moeten we 4 keer een model in een model steken.
		 * Deze functie plaats een Les met het bijhorende Vak als extra attribuut in een PersoonLes. Dit wordt herhaald voor alle Persoonlessen van een opgegeven persoon.
		 * @param Een $persoon waarvan je alles lessen wilt opvragen.
		 * @pre Je moet een functie hebben om alle lessen van een persoon op te vragen waar in elke les ook al het vak mee in zit.
		 * @post Dit wordt gebruikt om de studiepunten te berekenen.
		 * @return Dit returnt een Array met PersoonLessen
		 */
		function getAllPersoonLesWithLesAndVak($persoon){

        	//model laden+ alle PersoonLessen toevoegen
			$this->load->model('persoonLes_model');

			$persoonLessen = $this->persoonLes_model->getAllWithLesAndVak($persoon->id);

			return $persoonLessen;
			//OK return alle persoonlessen per persoon
		}

        /**
         * Retourneert het totaal aantal studiepunten van het record $persoonWithAllPersoonLesAndLesAndVak
         * @param $persoonWithAllPersoonLesAndLesAndVak het record  waarvan de studiepunten opgevraagd worden
         * @return Het totaal aantal studiepunten
         */
		function getStudiepunten($persoonWithAllPersoonLesAndLesAndVak)
		{
			$studiepunten =0;
			$gebruikteVakken = array();

			foreach ($persoonWithAllPersoonLesAndLesAndVak->persoonLessen as $persoonLes){
				if(!in_array($persoonLes->lesWithVak->vak->naam, $gebruikteVakken)) {
                    $studiepunten +=  $persoonLes->lesWithVak->vak->studiepunt;
                    array_push($gebruikteVakken, $persoonLes->lesWithVak->vak->naam);
                }
			}
			return $studiepunten;
		}

        /**
         * Retourneert het record met nummer=$nummer uit de tabel team22_persoon als wachtwoord=$wachtwoord
         * @param $nummer de nummer van het record  dat opgevraagd wordt
         * @param $wachtwoord het wachtwoord dat ingegeven is
         * @return Het opgevraagde record of null indien wachtwoord!=$wachtwoord
         */
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

        /**
         * Update het record met nummer=$nummer uit de tabel team22_persoon
         * @param $nummer de nummer van het record dat gewijzigd wordt
         * @param $secureGeneratedPassword het nieuwe wachtwoord
         */
        function setWachtwoordWhereNummer($nummer, $secureGeneratedPassword) {
            $data = array('wachtwoord' => $secureGeneratedPassword);
            $this->db->where('nummer', $nummer);
            $this->db->update('persoon', $data);
        }


        /**
         * Retourneert alle records met klasId=$klasId uit de tabel team22_persoon
         * @param $klasId de klasId van het record  dat opgevraagd wordt
         * @return Array met alle opgevraagde records
         */
        function getAllWhereKlas($klasId){

            $this->db->where('klasId', $klasId);
            $query = $this->db->get('persoon');
            return $query->result();
        }

        /**
         * Update het record met nummer=$nummer uit de tabel team22_persoon
         * @param $nummer de nummer van het record dat gewijzigd wordt
         * @param $klasId de nieuwe klasId
         */
        function setKlasIdWhereNummer($nummer, $klasId) {
            $data = array('klasId' => $klasId);
            $this->db->where('nummer', $nummer);
            $this->db->update('persoon', $data);
        }

        /**
         * Retourneert het record met typeId=$typeId of typeId=$typeId2 uit de tabel team22_persoon
         * @param $typeId het typeId van het record  dat opgevraagd wordt
         * @param $typeId2 het typeId van het record  dat opgevraagd wordt
         * @return Array met alle opgevraagde records
         */
        function getDocentWhereTypeid($typeId, $typeId2) {
            $this->db->where('typeId', $typeId);
            $this->db->or_where('typeId', $typeId2);
            $query = $this->db->get('persoon');
            return $query->result();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_persoon
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function getStudentnaam($id) {
            $this->db->where('id', $id);
            $query = $this->db->select('naam')->get('persoon');
            return $query->row();
        }

        /**
         * Retourneert alle records uit de tabel team22_persoon
         * @return Array met alle records
         */
        function getAll() {
            $query = $this->db->get('persoon');
            return $query->result();
        }

        /**
         * Retourneert alle records uit de tabel team22_persoon met bijhorende records uit de tabel team22_persoonType
         * @return Array met alle records met bijhorend type
         */
        function getAllWithType() {
            $query = $this->db->get('persoon');
            $personen = $query->result();

            foreach ($personen as $persoon) {
                $this->load->model("persoonType_model");
                $persoon->type = $this->persoonType_model->get($persoon->typeId);
            }
            
            return $personen;
        }
    }
