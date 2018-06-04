<?php
	require_once("./models/UpdateModel.php");
	require_once("./models/VerificationModel.php");

	/**
	 * mettre à jour utilisateur, item, collection
	 **/
	class UpdateController {
		//mise à jour utilisateur
		public function updateUser($tok){
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			if($user_id == 1 && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => 1,
					"firstname" => "Claudètte",
					"name" => "Poire",
					"pseudo" => "tatat'atat'at",
					"email" => "jojo@gmail.com",
					"password" => "gagagagag",
					);

				$ajout = new UpdateModel;
				$data = $ajout->updateUser($formData);
			    return $data;
			}else{
				echo "error";
			}
		    return $data;
		}
		
		//mise à jour collection
		public function updateCollection($tok){
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => 1,
					"title" => "Timbres",
					"description" => "Mes beaux tîmbres'",
					"image" => "collection-1.png"
				);
				$ajout = new UpdateModel;
				$data = $ajout->updateCollection($formData, $user_id);
				
			    return $data;
			}else{
				echo "error";
			}
		    return $data;
		}
		
		//mise à jour item
		public function updateItem($tok){
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => 1,
					"title" => "timb'ré1",
					"image" => "item-1.jpg",
					);
				$ajout = new UpdateModel;
				$data = $ajout->updateItem($formData);
			}else{
				echo "error";
			}
		    return $data;
		}
		
		//mise à jour cracteristique
		public function updateCaracteristique($tok){
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => 12,
					"caracteristiqueTitle" => "nômbre de pat'",
					"caracteristiqueObl" => 1
					);
				$ajout = new UpdateModel;
				$data = $ajout->updateCaracteristique($formData);
			}else{
				echo "error";
			}
		    return $data;
		}
	}