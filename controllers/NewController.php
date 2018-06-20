<?php
	require_once("./models/NewModel.php");
	require_once("./models/VerificationModel.php");

	/**
	 * ajouter utilisateurs, collection et item
	 **/
	class NewController {
		//nouvel utilisateur
		public function newUser(){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			
			$password = password_hash($obj["password"], PASSWORD_DEFAULT);
			$formData = array (
				"firstname" => $obj["firstname"],
				"name" => $obj["name"],
				"pseudo" => $obj["pseudo"],
				"email" => $obj["email"],
				"password" => $password,
				);
			$ajout = new NewModel;
			$data = $ajout->newUser($formData);
		    return json_encode($data);
		}
		
		//nouvelle collection
		public function newCollection($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			
			$caracteristiques = array();
			foreach($obj["carac"] as $carac){
				array_push($caracteristiques, 
					array(
						"caracteristiqueTitle" => $carac,
					)
				);		
			}
			$formData = array (
			"id" => $obj["id"],
			"title" => $obj["title"],
			"description" => $obj["description"],
			"image" => $obj["image"],
			"caracteristiques" => $caracteristiques
			
			);
			$ajout = new NewModel;
			$data = $ajout->newCollection($formData, $user_id);
			
		    return json_encode($data);
		}
		
		
		//nouvel item
		public function newItem($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$collectionId=$obj["id"];
			
			/*$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($collectionId); // on verifie si l'utilisateur a le  */
			
		//	if($user_id == $right["user_id"] && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit
				$caracteristiques = array();
				foreach($obj["carac"] as $carac){
					array_push($caracteristiques, 
						array(
							"caracData" => $carac["caracData"],
							"caracId" => $carac["caracId"],
						)
					);		
				}
			
				$formData = array (
					"id" => $obj["id"],
					"title" => $obj["title"],
					"image" => $obj["image"],
					"caracteristiques" => $caracteristiques
					);
				$ajout = new NewModel;
				$data = $ajout->newItem($formData);
				
				//var_dump($formdata);exit;
		/*	}else{
				echo "error";
			} */
		    return json_encode($data);
		}
		
		//nouvelle caracteristique
		public function newCaracteristique($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$collectionId=$obj["collectionId"];
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection($collectionId); // on verifie si l'utilisateur a le droit
			if($user_id == $right["user_id"] && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => $collectionId,
					"caracteristiqueTitle" => $obj["caracteristiqueTitle"],
					"caracteristiqueObl" => $obj["caracteristiqueObl"]
					);
				$ajout = new NewModel;
				$data = $ajout->newCaracteristique($formData);
			}else{
				echo "error";
			}
		    return json_encode($data);
		}
	}