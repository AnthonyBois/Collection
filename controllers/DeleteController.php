<?php
	require_once("./models/DeleteModel.php");
	require_once("./models/VerificationModel.php");

	/**
	 * supprimer utilisateur, collection et item
	 **/
	class DeleteController {
		//supprimer un utilisateur
		public function deleteUser($tok){
			$id=18;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			if($user_id == $id && $user_id != NULL){ //on supprime si l'utilisateur dans le token à le droit
				$supprime = new deleteModel;
				$data = $supprime->deleteUser($id);
			}else{
				echo "error";
			}
	        return $data;
		}
		
		//supprimer une collection
		public function deleteCollection($tok){
			//$id=27;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($id); // on verifie si l'utilisateur a le droit
			if($user_id == $right["user_id"] && $user_id != NULL){ //on supprime si l'utilisateur dans le token à le droit
				$supprime = new deleteModel;
				$data = $supprime->deleteCollection($id);
			}else{
				echo "error";
			}
	        return $data;

		}
		
		//supprimer un item
		public function deleteItem($tok){
			//$id=18;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifItem($id); // on verifie si l'utilisateur a le droit
			if($user_id == $right["user_id"] && $user_id != NULL){ //on supprime si l'utilisateur dans le token à le droit
				$supprime = new deleteModel;
				$data = $supprime->deleteItem($id);
			}else{
				echo "error";
			}
	        return $data;

		}
		
		
		//supprimer une caractéristique
		public function deleteCaracteristique($tok){
			$id=18;
			$idCollection=1;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($idCollection); // on verifie si l'utilisateur a le droit
			if($user_id == $right["user_id"] && $user_id != NULL){ //on supprime si l'utilisateur dans le token à le droit
				$supprime = new deleteModel;
				$data = $supprime->deleteCaracteristique($id);
			}else{
				echo "error";
			}
	        return $data;

		}
	}