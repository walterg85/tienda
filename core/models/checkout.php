<?php
	class Checkoutmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

		public function createOrder($data){
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO tienda.order
						(customer_id, amount, ship_price, shipping_address, order_date, payment_data, status)
				VALUES
					(:customer_id, :amount, :ship_price, :shipping_address, now(), :payment_data, now(), 1)
			';

			$parametros = array(
				':customer_id' 		=> $data['customer_id'],
				':amount' 			=> $data['amount'],
				':ship_price' 		=> $data['ship_price'],
				':shipping_address'	=> $data['shipping_address'],
				':payment_data'		=> $data['payment_data']
			);

			$order_id = 0;

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				$order_id = $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }

		    $cmd = '
				INSERT INTO order_log
						(order_id, status, comments, update_date)
				VALUES
					(:order_id, :status, :comments, now())
			';

			$parametros = array(
				':order_id' 		=> $order_id,
				':status' 			=> 1,
				':comments' 		=> 'a new purchase order is registered'
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $order_id;
	    }

	    public function createOrderDetail($data, $orderId){
			$pdo = new Conexion();

			foreach ($data as $key => $value) {
				$cmd = '
					INSERT INTO order_detail
							(order_id, product_id, price, quantity, amount)
					VALUES
						(:order_id, :product_id, :price, :quantity, amount)
				';

				$parametros = array(
					':order_id' 	=> $orderId,
					':product_id'	=> $data['product_id'],
					':price' 		=> $data['price'],
					':quantity'		=> $data['quantity'],
					':amount'		=> $data['amount']
				);

				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
			}

			return TRUE;
	    }
	}