<?php
	require_once("./models/VerificationModel.php");

	/**
	 * mettre à jour utilisateur, item, collection
	 **/
	class VerificationController {
		//mise à jour utilisateur
		public function verifPassword(){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$user = $obj["id"];
			$password = $obj["password"];
			$verif = new verificationModel;
			$mdp = $verif->verifPassword($user);
			$user_password = ($mdp["user_password"]);
			if(password_verify($password, $user_password)){ 
				return json_encode(1);
			}else{
				return json_encode(0);
			}

		}
	}