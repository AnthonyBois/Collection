<?php
	require_once("./models/ListModel.php");
	/**
	 * lister les utilisateurs, data et collections
	 **/
	class ListController {
		//liste les collections
		public function exportCollection($id, $idUser){
			$recherche = new listModel;
			$data = $recherche->listCollection($id,$idUser);

	        $dataEncode = json_encode($data);
	        return $dataEncode;
		}

		public function exportUser($id){
			//liste les utilisateurs
			$recherche = new listModel;
			$data = $recherche->listUser($id);

	        $dataEncode = json_encode($data);
	        return $dataEncode;
		}

		public function exportData($idCol){ 
			//liste les datas
			$recherche = new listModel; 
			$data = $recherche->listCaracteristique($idCol);
			
			
			//construction d'un tableau de data
			if(!empty($data)){
				$tableau = array();
				$tabItems = array();
				$tableau['user_id']=$data[0]["user_id"];
		        $tableau['user_name']=$data[0]["user_name"];
		        $tableau['collections']=array();
		        $i = -1;

				foreach ($data as $value) {
		            if($value['id_collection'] != $collection){
		                $collection = $value['id_collection'];
		                $i++;
		                $j = -1;
		                array_push($tableau["collections"], Array("id_collection" => $value["id_collection"], "nom_collection" => $value["nom_collection"], "items" => array()));
		            }
	
		            if($value['item_id'] != $item){
		                $item = $value['item_id'];
		                $j++;
		                array_push($tableau["collections"][$i]["items"], Array("item_id" => $value["item_id"], "item_name" => $value["item"], "item_image" => $value["image"], "caracteristiques" => array()));
		            }
	
		            if($value['id'] != $id){
		                $id = $value['id'];
		                array_push($tableau["collections"][$i]["items"][$j]["caracteristiques"], Array("id" => $value["id"], "title" => $value["title"], "data" => $value["data"]));
		            }
		        }
		        $dataEncode = json_encode($tableau);
		        return ($dataEncode);
			}else{
				return "null";
			}
			
		}
		
		public function exportItem($id){
			//1 item
			$recherche = new listModel;
			$data = $recherche->listItem($id);

			if(!empty($data)){
		        $tableau = array();
				$tabItems = array();
				$tableau['item_id']=$data[0]["item_id"];
		        $tableau['item_name']=$data[0]["item"];
		        $tableau['item_image']=$data[0]["image"];
		        $tableau['caracteristiques']=array();
		        $i = -1;
	
				foreach ($data as $value) {
		            if($value['id'] != $id){
		                $id = $value['id'];
		                array_push($tableau["caracteristiques"], Array("id" => $value["id"], "title" => $value["title"], "data" => $value["data"]));
		            }
		       }
			   $dataEncode = json_encode($tableau);
			   return $dataEncode;
			}else{
				return "null";
			}
		}
	}