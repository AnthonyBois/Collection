<?php
	/**
	 * récuppere dans la base de donnée
	 **/
	class ListModel {
		public function __construct(){
			$this->dbConnect();			
		}
		
		private function dbConnect(){
			$this->db = mysql_connect(DB_SERVER,DB_USER,DB_PASSWORD);
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET CHARACTER SET utf8");
			mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");
			mysql_query ("set character_set_results='utf8'");  
			mysql_set_charset('utf8');
			if($this->db)
				mysql_select_db(DB,$this->db);
				
		}


		// UTILISATEURS
		public function listUser($id){
			$where = "";
			if(!empty($id)){
				$where = " WHERE user.user_id ='$id' ";
			}
			$sql = mysql_query("
				SELECT 	user.user_id AS id,
						user.user_firstname AS firstname,
						user.user_name AS name,
						user.user_pseudo AS pseudo,
						user.user_email AS email,
						user.user_password AS password,
						user.user_image as image,
						COUNT(collection.collection_id) as nombre_collection,
						GROUP_CONCAT(collection.collection_id SEPARATOR ',' ) AS collections
				FROM user
				LEFT JOIN user_collection ON user_collection.user_id = user.user_id
				LEFT JOIN collection ON user_collection.collection_id = collection.collection_id
				$where
				GROUP BY user.user_id
				", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}

		// COLLECTION
		public function listCollection($id,$idUser){
			$where = "WHERE 1 = 1";
			if(!empty($id)){
				$where = $where." AND collection.collection_id ='$id' ";
			}
			if(!empty($idUser)){
				$where = $where." AND user.user_id ='$idUser' ";
			}
			$sql = mysql_query("
				SELECT 	collection.collection_id AS id, 
						collection.collection_title AS title, 
						collection.collection_description AS description, 
						collection.collection_image AS image, 
						collection.collection_private AS private, 
						user.user_id AS user_id,
						user.user_name AS user_name
				FROM collection
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				$where
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}
		
		// COLLECTION RANDOM
		public function listRandomCollection($idUser){
			$sql = mysql_query("
				SELECT 	collection.collection_id AS id, 
						collection.collection_title AS title, 
						collection.collection_description AS description, 
						collection.collection_image AS image, 
						collection.collection_private AS private, 
						user.user_id AS user_id,
						user.user_name AS user_name,
						user.user_pseudo as pseudo
				FROM collection
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				WHERE user.user_id <>'$idUser'
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}
		
		// COLLECTION RECHERCHE
		public function listRechercheCollection($string){
			$sql = mysql_query("
				SELECT 	collection.collection_id AS id, 
						collection.collection_title AS title, 
						collection.collection_description AS description, 
						collection.collection_image AS image, 
						collection.collection_private AS private, 
						user.user_id AS user_id,
						user.user_name AS user_name,
						user.user_pseudo as pseudo,
						COUNT(item.collection_id)
				FROM collection
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				LEFT JOIN item ON item.collection_id = collection.collection_id
				WHERE collection.collection_title LIKE '%$string%' OR user.user_name LIKE '%$string%'
				GROUP BY collection.collection_id
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}


		// CARACTERISTIQUES
		public function listCaracteristique($id){
			$where = "WHERE 1 = 1";
			$sql = mysql_query("
				SELECT 	caracteristique_value.caracteristique_value_id AS id, 
						caracteristique.caracteristique_title AS title, 
						caracteristique_value.caracteristique_value_data as data,
						item.item_id AS item_id,
						item.item_title AS item,
						item.item_image AS image,
						caracteristique.caracteristique_obligatoire AS obligatoire,
						collection.collection_id AS id_collection,
						collection.collection_title AS nom_collection,
						user.user_id AS user_id,
						user.user_name AS user_name
				FROM item
				LEFT JOIN caracteristique_value ON caracteristique_value.item_id = item.item_id 
				LEFT JOIN caracteristique_item ON caracteristique_value.caracteristique_item_id = caracteristique_item.caracteristique_item_id
				LEFT JOIN collection ON item.collection_id = collection.collection_id
				LEFT JOIN caracteristique ON caracteristique_item.caracteristique_id = caracteristique.caracteristique_id
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				WHERE collection.collection_id ='$id'
				ORDER BY item_id, id
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}
		
		// ITEM
		public function listItem($id){
			$where = "WHERE 1 = 1";
			$sql = mysql_query("
				SELECT 	caracteristique_value.caracteristique_value_id AS id, 
						caracteristique.caracteristique_title AS title, 
						caracteristique_value.caracteristique_value_data as data,
						item.item_id AS item_id,
						item.item_title AS item,
						item.item_image AS image,
						caracteristique.caracteristique_obligatoire AS obligatoire,
						collection.collection_id AS id_collection,
						collection.collection_title AS nom_collection,
						user.user_id AS user_id,
						user.user_name AS user_name
				FROM item
				LEFT JOIN caracteristique_value ON caracteristique_value.item_id = item.item_id 
				LEFT JOIN caracteristique_item ON caracteristique_value.caracteristique_item_id = caracteristique_item.caracteristique_item_id
				LEFT JOIN collection ON item.collection_id = collection.collection_id
				LEFT JOIN caracteristique ON caracteristique_item.caracteristique_id = caracteristique.caracteristique_id
				LEFT JOIN user_collection ON user_collection.collection_id = collection.collection_id
				LEFT JOIN user ON user_collection.user_id = user.user_id
				WHERE item.item_id ='$id'
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}
		
		// ITEM
		public function listCarac($id){
			$where = "WHERE 1 = 1";
			$sql = mysql_query("
				SELECT caracteristique.caracteristique_id, caracteristique.caracteristique_title
				FROM caracteristique
				LEFT JOIN caracteristique_item ON caracteristique_item.caracteristique_id = caracteristique.caracteristique_id
				LEFT JOIN collection ON collection.collection_id = caracteristique_item.collection_id
				WHERE collection.collection_id = $id
			", $this->db);

			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
			}
			return $result;
		}
	}
