<?php
	/**
	 * met à jour dans la base de donnée
	 **/
	class UpdateModel {
		//constructeur
		public function __construct(){
			$this->dbConnect();			
		}
		
		//connexion à la base de donnée
		private function dbConnect(){
			$this->db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		}
		
		//modifie utilisateur
		public function updateUser($formData){
			$sql = $this->db->prepare("
				UPDATE user
				SET user_firstname = :firstname, user_name = :name, user_pseudo = :pseudo, user_email = :email
				WHERE user_id = :id
				");
			$sql->bindValue('firstname', $formData['firstname'], PDO::PARAM_INT);
			$sql->bindValue('name', $formData['name'], PDO::PARAM_INT );
			$sql->bindValue('pseudo', $formData['pseudo'], PDO::PARAM_INT);
			$sql->bindValue('email', $formData['email'], PDO::PARAM_INT);
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
		
		//modifie collection
		public function updateCollection($formData){
			$sql = $this->db->prepare("
				UPDATE collection
				SET collection_title = :title, collection_description = :description
				WHERE collection_id = :id
				");
			$sql->bindValue('title', $formData['title'], PDO::PARAM_INT);
			$sql->bindValue('description', $formData['description'], PDO::PARAM_INT );
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
		
		//modifie item
		public function updateItem($formData){

			$sql = $this->db->prepare("
				UPDATE item
				SET item_title = :title, item_image = :image
				WHERE item_id = :id
				");
			$sql->bindValue('title', $formData['title'], PDO::PARAM_INT);
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();

			return "bien modifié";
		}
		
		//modifie caracteristique
		public function updateCaracteristique($formData){
			$sql = $this->db->prepare("
				UPDATE caracteristique
				SET caracteristique_title = :caracteristiqueTitle, caracteristique_obligatoire = :caracteristiqueObl
				WHERE caracteristique_id = :id
				");
			$sql->bindValue('caracteristiqueTitle', $formData['caracteristiqueTitle'], PDO::PARAM_INT);
			$sql->bindValue('caracteristiqueObl', $formData['caracteristiqueObl'], PDO::PARAM_INT );
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
		
		//modifie image user
		public function updateImgUser($formData){
			$sql = $this->db->prepare("
				UPDATE user
				SET user_image = :image
				WHERE user_id = :id
			");
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
		
		//modifie image collection
		public function updateImgCollection($formData){
			$sql = $this->db->prepare("
				UPDATE collection
				SET collection_image = :image
				WHERE collection_id = :id
			");
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
		
		//modifie image item
		public function updateImgItem($formData){
			$sql = $this->db->prepare("
				UPDATE item
				SET item_image = :image
				WHERE item_id = :id
			");
			$sql->bindValue('image', $formData['image'], PDO::PARAM_INT);
			$sql->bindValue('id', $formData['id'], PDO::PARAM_INT);
			$sql->execute();
			return "bien modifié";
		}
	}