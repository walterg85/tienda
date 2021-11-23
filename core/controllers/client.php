<?php
	session_start();
	
	require_once '../models/client.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$clientModel 	= new Clientmodel();
		$response 		= array(
			'codeResponse' => 0
		);

		if($vars['_method'] == 'POST'){
			$clientData = array(
				'inputName' 	=> $vars['inputName'],
				'inputLastname' => $vars['inputLastname'],
				'inputAddress'	=> $vars['inputAddress'],
				'inputAddress2'	=> $vars['inputAddress2'],
				'inputPhone'	=> $vars['inputPhone'],
				'inputCity'		=> $vars['inputCity'],
				'inputState'	=> $vars['inputState'],
				'inputZip'		=> $vars['inputZip'],
				'inputInfo'		=> $vars['inputInfo']
			);

			if($vars['clientId'] == 0){
				$tmpResponse = $clientModel->register($clientData);
			}else{
				$prodData['clientId'] 	= $vars['clientId'];				
				$tmpResponse 			= $clientModel->updates($prodData);
			}

			if($tmpResponse){
				$response = array(
					'codeResponse' => 200
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