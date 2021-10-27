<?php
	session_start();
	
	require_once '../models/category.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars = ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);

		if($vars['_method'] == 'Get'){
			$categoryModel = new Categorymodel();

			$response = array(
				'codeResponse' => 200,
				'data' => $categoryModel->get()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		} else if($vars['_method'] == 'POST'){
			$categoryModel = new Categorymodel();

			$tmpResponse = $categoryModel->register($vars['name']);

			if($tmpResponse){
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
		} else if($vars['_method'] == 'Delete'){
			$categoryModel = new Categorymodel();
			$categoryModel->delete($vars['categoryId']);

			$response = array(
				'codeResponse' => 200
			);

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