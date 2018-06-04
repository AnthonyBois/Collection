<?php
	require_once("./models/NewModel.php");
	require_once("./models/VerificationModel.php");

	/**
	 * ajouter utilisateurs, collection et item
	 **/
	class NewController {
		//nouvel utilisateur
		public function newUser(){
			$password = password_hash("super", PASSWORD_DEFAULT);
			echo $password;
			$formData = array (
				"firstname" => "jean",
				"name" => "Pomme",
				"pseudo" => "jp",
				"email" => "pj'jj@yahooooooo.com",
				"password" => $password
				);
			$ajout = new NewModel;
			$data = $ajout->newUser($formData);
		    return $data;
		}
		
		//nouvelle collection
		public function newCollection($tok){
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);

			$formData = array (
			"title" => "Table",
			"description" => "Mes plus belles tables",
			"image" => "table.png",
			"caracteristiques" => array(
				"1" => array(
					"caracteristiqueTitle" => "couleur",
					"caracteristiqueObl" => 1
					),
				"2" => array(
					"caracteristiqueTitle" => "vitre",
					"caracteristiqueObl" => 1
					)
				)
			);
			$ajout = new NewModel;
			$data = $ajout->newCollection($formData, $user_id);
			
		    return $data;
		}
		
		//nouvel item
		public function newItem($tok){
			$collectionId=26;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($collectionId); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit
				$formData = array (
					"title" => "Poulé'3",
					"image" => "zâer.png",
					"caracteristiques" => array(
						"1" => array(
							"caracData" => "8",
							"caracId" => 56
							),
						"2" => array(
							"caracData" => "23",
							"caracId" => 12
							)
						)
					);
				$ajout = new NewModel;
				$data = $ajout->newItem($formData, $collectionId);
			}else{
				echo "error";
			}
		    return $data;
		}
		
		//nouvelle caracteristique
		public function newCaracteristique($tok){
			$collectionId=1;
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($collectionId); // on verifie si l'utilisateur a le droit
			if($user_id == $right["user_id"] && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => $collectionId,
					"caracteristiqueTitle" => "ör'igine",
					"caracteristiqueObl" => 1
					);
				$ajout = new NewModel;
				$data = $ajout->newCaracteristique($formData);
			}else{
				echo "error";
			}
		    return $data;
		}
	}