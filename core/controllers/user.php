<?php
	session_start();
	
	require_once '../models/user.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars = ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);

		if($vars['_method'] == 'initDefaultUser'){
			$userModel = new Usersmodel();
			$data = array(
				'owner' => 'admin',
				'email' => '',
				'password' => encriptPass('12345'),
				'type' => 1
			);
			$tmpResponse	= $userModel->createUser($data);

			if($tmpResponse[0]){
				$response = array(
					'codeResponse' => 200,
					'id' => $tmpResponse[1],
					'message' => 'User account successfully registered.'
				);
			}else{
				$message = '';
				switch ($tmpResponse[1]) {
					case '23000':
						$message = 'Email is registered, try another email.';
						break;				
					default:
						$message = 'general error in the database.';
						break;
				}

				$response = array(
					'codeResponse' => 0,
					'message' => $message
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		} else if($vars['_method'] == 'VALIDATE'){
			$userModel = new Usersmodel();
			$tmpResponse = $userModel->login($vars['uname']);

			$response = array(
				'codeResponse' => 0,
				'message' => 'Username or password incorrect'
			);

			if($tmpResponse){
				if (password_verify($vars['password'], $tmpResponse->password)){
					unset($tmpResponse->password);

					$headers = array('alg' => 'HS256', 'typ' => 'JWT');
					$payload = array('username' => $vars['uanme'], 'exp' => (time() + 86400));
					$tmpResponse->token = generate_jwt($headers, $payload);

					$response = array(
						'codeResponse' => 200,
						'data' => $tmpResponse,
						'message' => 'Welcome'
					);

					$_SESSION['isLoged'] = TRUE;
					$_SESSION['authData'] = $tmpResponse;
				}
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		}
	}

	function encriptPass($strPassword) {
		$options = [
		    'cost' => 12
		];

		return password_hash($strPassword, PASSWORD_BCRYPT, $options);
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);

	exit( json_encode($response) );