<?php 
	require_once("./app/config.php");
	require_once("./controllers/ListController.php");
	require_once("./controllers/DeleteController.php");
	require_once("./controllers/NewController.php");
	require_once("./controllers/ConnexionController.php");
	require_once("./controllers/UpdateController.php");

	//récuppération des parametres de l'url
	$controller = $_GET['action'];
	$function = $_GET['fonction'];
	$id = $_GET['id'];
	$idUser = $_GET['idUser'];
	$idCollection = $_GET['idCollection'];
	$tok = $_GET["tok"];


	switch ($controller) {
	    case "list":
	    	$liste = new ListController;
	    	switch ($function) {
			    case "users":
			    	$data = $liste->exportUser($id);
			        break;
			    case "collections":
			        $data = $liste->exportCollection($id, $idUser);
			        break;
			    case "datas":
			        $data = $liste->exportData($id);
			        break;
			    case "item":
			        $data = $liste->exportItem($id);
			        break;
			    default:
			    	$data = "null";
			}
	        break;
	    case "delete":
	    	$suppr = new DeleteController;
	    	switch ($function) {
			    case "user":
			    	$data = $suppr->deleteUser($tok);
			        break;
			    case "collection":
			        $data = $suppr->deleteCollection($tok);
			        break;
			    case "item":
			        $data = $suppr->deleteItem($tok);
			        break;
				case "caracteristique":
			    	$data = $suppr->deleteCaracteristique($tok);
			        break;
			    default:
			    	$data = "null";
			}
	        break;
	    case "update":
	    	$update = new UpdateController;
	        switch ($function) {
			    case "user":
			    	$data = $update->updateUser($tok);
			        break;
			    case "collection":
			    	$data = $update->updateCollection($tok);
			        break;
			    case "item":
			    	$data = $update->updateItem($tok);
			        break;
			    case "caracteristique":
			    	$data = $update->updateCaracteristique($tok);
			        break;
			    default:
			    	$data = "null";
			}
	        break;
	    case "new":
	    	$nouveau = new NewController;
	        switch ($function) {
			    case "user":
			    	$data = $nouveau->newUser();
			        break;
			    case "collection":
			    	$data = $nouveau->newCollection($tok);
			        break;
			    case "item":
			    	$data = $nouveau->newItem($tok);
			        break;
			    case "caracteristique":
			    	$data = $nouveau->newCaracteristique($tok);
			        break;
			    default:
			    	$data = "null";
			}
	        break;
	    case "connexion":
	    	$connect = new ConnexionController;
	    	if($function == "newmdp"){
		    	$data = $connect->newPassword();
	    	}else{
	    		$data = $connect->connect();
	    	}
	        break;
	    default:
			$data = "null";
	}
    echo($data);