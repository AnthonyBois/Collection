<?php
	require_once("./models/UpdateModel.php");
	require_once("./models/VerificationModel.php");

	/**
	 * mettre à jour utilisateur, item, collection
	 **/
	class UpdateController {
		//mise à jour utilisateur
		public function updateUser($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			//if($user_id == $obj["id"] && $user_id != NULL){  //on ajoute si l'utilisateur dans le token à le droit

				$password = password_hash($obj["password"], PASSWORD_DEFAULT);
				
				$formData = array (
					"id" => $obj["id"],
					"firstname" => $obj["firstname"],
					"name" => $obj["name"],
					"pseudo" => $obj["pseudo"],
					"email" => $obj["email"],
					);

				$ajout = new UpdateModel;
				$data = $ajout->updateUser($formData);
			    return json_encode($data);
			/*}else{
				echo "error";
			}*/
		    return json_encode($data);
		}
		
		//mise à jour image
		public function uploadImage($tok){
			header('Access-Control-Allow-Origin: *');
			$target_path = $_SERVER['DOCUMENT_ROOT'] . "/images/";;
			 
			$target_path = $target_path . basename( $_FILES['file']['name']);
			 
			if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			    return json_encode("Upload and move success");
			} else{
			    return json_encode($target_path."There was an error uploading the file, please try again!");
			}
		}
		
		//mise à jour collection
		public function updateCollection($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$image = $_FILES['image'];
				$uploadImg = new ImageModel;
				$name = $uploadImg->uploadImage($image);
				$formData = array (
					"id" => $obj["id"],
					"title" => $obj["title"],
					"description" => $obj["description"],
					"image" => $name
				);
				$ajout = new UpdateModel;
				$data = $ajout->updateCollection($formData, $user_id);
				
			    return $data;
			}else{
				echo "error";
			}
		    return json_encode($data);
		}
		
		//mise à jour item
		public function updateItem($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$image = $_FILES['image'];
				$uploadImg = new ImageModel;
				$name = $uploadImg->uploadImage($image);
				$formData = array (
					"id" => $obj["id"],
					"title" => $obj["title"],
					"image" => $name,
					);
				$ajout = new UpdateModel;
				$data = $ajout->updateItem($formData);
			}else{
				echo "error";
			}
		    return json_encode($data);
		}
		
		//mise à jour cracteristique
		public function updateCaracteristique($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	
			$verif = new verificationModel;
			$decode = $verif->decodeToken($tok); //decode le token
			$user_id = ($decode["user_id"]);
			$right = $verif->verifCollection(1); // on verifie si l'utilisateur a le droit
			
			if($user_id == $right["user_id"] && $user_id != NULL){  //on modifie si l'utilisateur dans le token à le droit
				$formData = array (
					"id" => $obj["id"],
					"caracteristiqueTitle" => $obj["caracteristiqueTitle"],
					"caracteristiqueObl" => $obj["caracteristiqueObl"]
					);
				$ajout = new UpdateModel;
				$data = $ajout->updateCaracteristique($formData);
			}else{
				echo "error";
			}
		    return json_encode($data);
		}
		
		//mise à jour img user
		public function updateImgUser($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	

			$formData = array (
				"id" => $obj["id"],
				"image" => $obj["image"],
			);

			$ajout = new UpdateModel;
			$data = $ajout->updateImgUser($formData);

		    return json_encode($data);
		}
		
		//mise à jour img collection
		public function updateImgCollection($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	

			$formData = array (
				"id" => $obj["id"],
				"image" => $obj["image"],
			);

			$ajout = new UpdateModel;
			$data = $ajout->updateImgCollection($formData);

		    return json_encode($data);
		}
		
		//mise à jour img item
		public function updateImgItem($tok){
			$json=file_get_contents('php://input');
			$obj=json_decode($json, true);	

			$formData = array (
				"id" => $obj["id"],
				"image" => $obj["image"],
			);

			$ajout = new UpdateModel;
			$data = $ajout->updateImgItem($formData);

		    return json_encode($data);
		}
	}