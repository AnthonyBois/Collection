<?php
	/**
	 * supprime de la base de donnée
	 **/
	class DeleteModel {
		public function __construct(){
			$this->dbConnect();			
		}
		
		//connexion à la base de donnée
		private function dbConnect(){
			$this->db = mysql_connect(DB_SERVER,DB_USER,DB_PASSWORD);
			if($this->db)
				mysql_select_db(DB,$this->db);
		}
		
		// UTILISATEUR
		public function deleteUser($id){
			$sql = mysql_query("
				DELETE FROM user WHERE user.user_id = $id
				", $this->db);
			return "bien supprimé";
		}
		
		// COLLECTION
		public function deleteCollection($id){
			$sql = mysql_query("
				DELETE FROM collection WHERE collection_id = $id
				", $this->db);
				$sql = mysql_query("
				DELETE FROM caracteristique_item WHERE collection_id = $id
				", $this->db);
				$sql = mysql_query("
				DELETE FROM user_collection WHERE collection_id = $id
				", $this->db);
				$sql = mysql_query("
				DELETE FROM item WHERE collection_id = $id
				", $this->db);
				// delete data
			return "bien supprimé";
		}
		
		// ITEM
		public function deleteItem($id){
			$sql = mysql_query("
				DELETE FROM item WHERE item_id = $id
				", $this->db);
				$sql = mysql_query("
				DELETE FROM caracteristique_value WHERE item_id = $id
				", $this->db);
			return "bien supprimé";
		}
		
		// CARACTERISTIQUE
		public function deleteCaracteristique($id){
			$sql = mysql_query("
				DELETE FROM caracteristique WHERE caracteristique_id = $id
				", $this->db);
				$sql = mysql_query("
				DELETE FROM caracteristique_item WHERE caracteristique_id = $id
				", $this->db);
			return "bien supprimé";
		}
	}