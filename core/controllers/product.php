<?php
	session_start();
	
	require_once '../models/product.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars = ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);

		if($vars['_method'] == 'POST'){
			$prodData = array(
				'inputName' 			=> $vars['inputName'],
				'inputNameSp' 			=> $vars['inputNameSp'],
				'inputDescription'		=> $vars['inputDescription'],
				'inputDescriptionSp'	=> $vars['inputDescriptionSp'],
				'inputPrice'			=> floatval($vars['inputPrice']),
				'inputSalePrice'		=> floatval($vars['inputSalePrice']),
				'inputUnit' 			=> $vars['inputUnit'],
				'inputCategory' 		=> $vars['inputCategory'],
				'productId' 			=> $vars['productId']
			);

			$productModel = new Productmodel();
			if($vars['productId'] == 0){
				$tmpResponse = $productModel->register($prodData);
			}			

			if($tmpResponse[0]){
				$productId = $tmpResponse[1];

				if (!empty($_FILES['imagesproduct'])){
					$folder   = "assets/img/products/{$productId}";
					mkdir(dirname(__FILE__, 3) . "/{$folder}", 0777, true);

					$imagesprod = $_FILES['imagesproduct'];
					$images		= array();
					foreach($imagesprod['name'] as $key => $imagesproduct) {
						$_FILES['imagesproduct[]']['name']		= $imagesprod['name'][$key];
			            $_FILES['imagesproduct[]']['type']		= $imagesprod['type'][$key];
			            $_FILES['imagesproduct[]']['tmp_name']	= $imagesprod['tmp_name'][$key];
			            $_FILES['imagesproduct[]']['error']		= $imagesprod['error'][$key];
			            $_FILES['imagesproduct[]']['size']		= $imagesprod['size'][$key];

						$filename = $imagesprod['name'][$key];
						$tempname = $imagesprod['tmp_name'][$key];

						if (move_uploaded_file($tempname, "../../{$folder}/{$filename}"))
							array_push($images, "{$folder}/{$filename}");
					}

					if(count($images) > 0)
						$productModel->updateThumbnails($productId, $images[0], json_encode($images, JSON_FORCE_OBJECT));
				}

				$response = array(
					'codeResponse' => 200
				);
			}else{
				$response = array(
					'codeResponse' => 0
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);

	exit( json_encode($response) );