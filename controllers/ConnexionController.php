<?php
	require_once("./models/ConnexionModel.php");
	
	/**
	 * authentifier et récuppérer le token
	 **/
	class ConnexionController {
		// se connecter
		public function connect(){
			$connect = new connexionModel;
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$email = $obj["email"]; 
			$password = $obj["password"];
			
			$data = $connect->connect($email, $password);
			
	        return json_encode($data);
		}
		
		public function newPassword(){
			$message = "Line 1\r\nLine 2\r\nLine 3";
			
			// Envoi du mail
			mail('anthony.bois73@gmail.com', 'Mon Sujet', $message);
		}
	}