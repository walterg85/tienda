<?php
	class Productmodel
	{
		public function __construct()
	    {
	        require_once '../dbConnection.php';
	    }

		public function register($data)
		{
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO product
						(sku, name, descriptions, price, discount, discount_available, unit, weight, dimensions, stock, create_date, active)
				VALUES
					(:sku, :name, :descriptions, :price, :discount, :discount_available, :unit, :weight, :dimensions, :stock, now(), 1)
			';

			$parametros = array(
				':sku' 					=> $data['inputSku'],
				':name' 				=> $data['inputName'],
				':descriptions' 		=> $data['inputDescription'],
				':price' 				=> $data['inputPrice'],
				':discount' 			=> $data['inputDiscount'],
				':discount_available'	=> $data['inputDiscountAvailable'],
				':unit' 				=> $data['inputUnit'],
				':weight' 				=> $data['inputWeight'],
				':dimensions' 			=> $data['inputDimensions'],
				':stock' 				=> $data['inputStock']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return [TRUE, $pdo->lastInsertId()];
			} catch (PDOException $e) {
		        return [FALSE, $e->getCode()];
		    }
		}

		public function updateThumbnails($productId, $thumbnails, $images)
		{
			$pdo = new Conexion();
			$cmd = 'UPDATE product SET thumbnail =:thumbnail, images =:images WHERE id =:productId';

			$parametros = array(
				':thumbnail' => $thumbnails,
				':productId' => $productId,
				':images'	 => $images
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}
	}