<?php
	/**
	 * vérifie si l'utilisateur à le droit ou non
	 **/
	class verificationModel {
		//constructeur
		public function __construct(){
			$this->dbConnect();			
		}
		
		//connexion à la base de donnée
		private function dbConnect(){
			$this->db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB, DB_USER, DB_PASSWORD);
		}
		
		// ITEM
		public function verifItem($id){
			$sql = $this->db->prepare("
				SELECT item.item_id, user.user_id
				FROM item
				LEFT JOIN caracteristique_value ON caracteristique_value.item_id = item.item_id 
				LEFT JOIN caracteristique_item ON caracteristique_value.caracteristique_item_id = caracteristique_item.caracteristique_item_id
				LEFT JOIN collection ON item.collection_id = collection.collection_id
				LEFT JOIN caracteristique ON caracteristique_item.caracteristique_id = caracteristique.caracteristique_id
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				WHERE item.item_id ='$id'
			");
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_ASSOC);
			return $result;
		}
		
		// COLLECTION
		public function verifCollection($id){
			$sql = $this->db->prepare("
				SELECT collection.collection_id, user.user_id
				FROM collection
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				WHERE collection.collection_id ='$id'
			");
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_ASSOC);
			return $result;
		}
		
		// decoder le token
		public function decodeToken($tok){
	        list($header, $payload, $signature) = explode (".", $tok); //explode du token
			$decode = json_decode(base64_decode($payload), true); //decode du token
			
			return $decode;
	    }

	}