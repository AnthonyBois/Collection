<?php
	/**
	 * aajoute dans la base de donnée
	 **/
	class NewModel {
		//constructeur
		public function __construct(){
			$this->dbConnect();			
		}
		
		//connexion à la base de donnée
		private function dbConnect(){
			$this->db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		}
		
		// UTILISATEUR
		public function newUser($formData){
			$sql = $this->db->prepare("
				INSERT INTO user (user_firstname, user_name, user_pseudo, user_email, user_password, user_create_time)
				VALUES (:firstname, :name, :pseudo, :email, :password, NOW())
				");
			$sql->bindValue('firstname', $formData['firstname'], PDO::PARAM_INT);
			$sql->bindValue('name', $formData['name'], PDO::PARAM_INT );
			$sql->bindValue('pseudo', $formData['pseudo'], PDO::PARAM_INT);
			$sql->bindValue('email', $formData['email'], PDO::PARAM_INT);
			$sql->bindValue('password', $formData['password'], PDO::PARAM_INT);
			$sql->execute();
			return "bien ajouté";
		}
		
		// COLLECTION
		public function newCollection($formData, $idUser){
			$sql = $this->db->prepare("
				INSERT INTO collection (collection_title, collection_description, collection_image, collection_create_time)
				VALUES (:title, :description, :image, NOW())
				");
			$sql->bindValue('title', $formData['title'], PDO::PARAM_INT);
			$sql->bindValue('description', $formData['description'], PDO::PARAM_INT );
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->execute();
			
			
			
			$collectionId = $this->db->lastInsertId();
			$sql = $this->db->prepare("
				INSERT INTO user_collection (collection_id, user_id, role_id)
				VALUES (:collectionId, :idUser, 1)
				");
			$sql->bindValue('collectionId', $collectionId, PDO::PARAM_INT);
			$sql->bindValue('idUser', $idUser, PDO::PARAM_INT );
			$sql->execute();
			
			
			
			
			 foreach($formData['caracteristiques']	as $value){
			 	$sql = $this->db->prepare("
					INSERT INTO caracteristique (caracteristique_title, caracteristique_obligatoire)
					VALUES (:caracteristiqueTitle, :caracteristiqueObl)
					");
				$sql->bindValue('caracteristiqueTitle', $value['caracteristiqueTitle'], PDO::PARAM_INT);
				$sql->bindValue('caracteristiqueObl', $value['caracteristiqueObl'], PDO::PARAM_INT );
				$sql->execute();
				
				$caracId = $this->db->lastInsertId();
				$sql = $this->db->prepare("
					INSERT INTO caracteristique_item (collection_id, caracteristique_id)
					VALUES ('$collectionId', '$caracId')
					");
				$sql->execute();
			 }
			
			
			return "bien ajouté";
		}
		
		
		// ITEM
		public function newItem($formData, $collectionId){
			$title = $formData['title'];
			$image = $formData['image'];
			$sql = $this->db->prepare("
				INSERT INTO item (item_title, item_image, collection_id)
				VALUES (:title, :image, $collectionId)
				");
			$sql->bindValue('title', $formData['title'], PDO::PARAM_INT);
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->execute();
			
			$itemId = $this->db->lastInsertId();
			
			foreach($formData['caracteristiques']	as $value){
				$caracData = $value['caracData'];
				$caracId = $value['caracId'];
			 	$sql = $this->db->prepare("
					INSERT INTO caracteristique_value (caracteristique_value_data, caracteristique_item_id, item_id)
					VALUES (:caracData, :caracId, :itemId)
					");
				$sql->bindValue('caracData', $value['caracData'], PDO::PARAM_INT);
				$sql->bindValue('caracId', $value['caracId'], PDO::PARAM_INT);
				$sql->bindValue('itemId', $itemId, PDO::PARAM_INT);
				$sql->execute();
			 }
			 
			
			
			return "bien ajouté";
		}
		
		
		
		// CARACTERISTIQUE
		public function newCaracteristique($formData){
			$collectionId = $formData['id'];
		 	$caracteristiqueTitle = $formData['caracteristiqueTitle'];
			$caracteristiqueObl = $formData['caracteristiqueObl'];
		 	$sql = $this->db->prepare("
				INSERT INTO caracteristique (caracteristique_title, caracteristique_obligatoire)
				VALUES (:caracteristiqueTitle, :caracteristiqueObl)
				");
			$sql->bindValue('caracteristiqueTitle', $formData['caracteristiqueTitle'], PDO::PARAM_INT);
			$sql->bindValue('caracteristiqueObl', $formData['caracteristiqueObl'], PDO::PARAM_INT );
			$sql->execute();
			
			$caracId = $this->db->lastInsertId();
			$sql = $this->db->prepare("
				INSERT INTO caracteristique_item (collection_id, caracteristique_id)
				VALUES (:collectionId, :caracId)
				");
			$sql->bindValue('collectionId', $formData['id'], PDO::PARAM_INT);
			$sql->bindValue('caracId', $caracId , PDO::PARAM_INT );
			$sql->execute();
			 
			return "bien ajouté";
		}
	}