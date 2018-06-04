<?php
	/**
	 * connexion
	 **/
	class ConnexionModel {
		//constructeur
		public function __construct(){
			$this->dbConnect();			
		}
		
		//connexion à la base de donnée
		private function dbConnect(){
			$this->db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB, DB_USER, DB_PASSWORD);
		}
		
		//connexion
		public function connect($username, $password){	 
			$sql = 'SELECT * FROM user WHERE user_email = :username';
			$sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':username' => $username));
			$result = $sth->fetchAll();
			
			foreach  ($result as $row) {
		        $user_password = $row['user_password'];
		       
		  }
					
		if($result){
			if (password_verify($password, $user_password)) {
					// Create token header as a JSON string
					$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
					
					// Create token payload as a JSON string
					$payload = json_encode(['user_id' => $result["user_id"]]);
					
					// Encode Header to Base64Url String
					$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
					
					// Encode Payload to Base64Url String
					$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
					
					// Create Signature Hash
					$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, '_s(yèe-ss45bl(oej+45456g', true);
					
					// Encode Signature to Base64Url String
					$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
					
					// Create JWT
					$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
					
					return $jwt;
				}
			}else{
				return "null";
			}
			
		}
	}