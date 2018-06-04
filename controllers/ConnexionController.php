<?php
	require_once("./models/ConnexionModel.php");
	
	/**
	 * authentifier et récuppérer le token
	 **/
	class ConnexionController {
		// se connecter
		public function connect(){
			$connect = new connexionModel;

			$email = "j'@yahooooooo.com";
			$password = "super";
			$data = $connect->connect($email, $password);
			
	        return $data;
		}
		
		public function newPassword(){
			$message = "Line 1\r\nLine 2\r\nLine 3";
			
			// Envoi du mail
			mail('anthony.bois73@gmail.com', 'Mon Sujet', $message);
		}
	}