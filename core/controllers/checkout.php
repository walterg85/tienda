<?php
	session_start();
	
	require_once '../models/checkout.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars = ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);

		if($vars['_method'] == '_POST'){
			$checkoutModel = new Checkoutmodel();

			$orderData = array(
				'customer_id' => ( isset($_SESSION['isLoged']) ) ? $_SESSION['authData']->id : 0,
				'amount' => $vars['amount'],
				'ship_price' => $vars['ship_price'],
				'shipping_address' => $vars['shipping_address'],
				'payment_data' => $vars['payment_data'],
				'coupon' => $vars['coupon']
			);

			$order = $checkoutModel->createOrder($orderData);

			if($order){
				$response = array(
					'codeResponse' => 200,
					'message' => 'Registered order',
					'id' => $order
				);
				$checkoutModel->createOrderDetail( json_decode($vars['order'], TRUE), $order );
			}else{
				$response = array(
					'codeResponse' => 0,
					'message' => 'order not registered'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		} else if($vars['_method'] == '_GET') {
			$checkoutModel 	= new Checkoutmodel();

			$response = array(
				'codeResponse' => 200,
				'data' => $checkoutModel->getOrder( $vars['currentOrderId'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		} else if($vars['_method'] == 'GetCoupon') {
			$checkoutModel 	= new Checkoutmodel();

			$response = array(
				'codeResponse' => 200,
				'data' => $checkoutModel->GetCoupon( $vars['code'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			
			exit(json_encode($response));
		} else if($vars['_method'] == 'GetOrders') {
			$checkoutModel 	= new Checkoutmodel();

			$response = array(
				'codeResponse' => 200,
				'data' => $checkoutModel->GetOrders()
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