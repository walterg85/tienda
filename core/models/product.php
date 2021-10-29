<?php
	class Productmodel
	{
		public function __construct()
	    {
	        require_once '../dbConnection.php';
	    }

		public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO product
						(name, descriptions, price, sale_price, optional_name, optional_description, create_date, active)
				VALUES
					(:name, :descriptions, :price, :sale_price, :optional_name, :optional_description, now(), 1)
			';

			$parametros = array(
				':name' 				=> $data['inputName'],
				':descriptions' 		=> $data['inputDescription'],
				':price' 				=> $data['inputPrice'],
				':sale_price' 			=> $data['inputSalePrice'],
				':optional_name'		=> $data['inputNameSp'],
				':optional_description' => $data['inputDescriptionSp']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return [TRUE, $pdo->lastInsertId()];
			} catch (PDOException $e) {
		        return [FALSE, $e->getCode()];
		    }
		}

		public function updateThumbnails($productId, $thumbnails, $images) {
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

		public function insertCategory($productId, $categoryId) {
			$pdo = new Conexion();
			$cmd = '
				DELETE FROM product_category WHERE product_id =:product_id;
				INSERT INTO  product_category (category_id, product_id) VALUES (:category_id, :product_id);
			';

			$parametros = array(
				':category_id' => $categoryId,
				':product_id' => $productId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function getProduct() {
			$pdo = new Conexion();

			$cmd = '
				SELECT
					id, 
					name,
					optional_name,
					descriptions, 
					optional_description,
					price,
					sale_price, 
					thumbnail, 
					images, 
					create_date
				FROM 
					product
				WHERE active = 1
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getCategories($productId) {
			$pdo = new Conexion();

			$parametros = array(
				':product_id' => $productId
			);

			$cmd = 'SELECT id, name FROM category WHERE id = ( select category_id from product_category where product_id =:product_id )';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}

		public function deleteProduct($productId) {
			$pdo 	= new Conexion();
			$cmd 	= 'UPDATE product SET active = 0 WHERE id =:productId';

			$parametros = array(
				':productId' => $productId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function updates($data) {
			$pdo = new Conexion();
			$cmd = '
				UPDATE product SET
					name =:name, 
					optional_name =:optional_name,
					descriptions =:descriptions, 
					optional_description =:optional_description,
					price =:price, 
					sale_price =:sale_price
				WHERE id =:productId
			';

			$parametros = array(
				':name' 				=> $data['inputName'],
				':descriptions' 		=> $data['inputDescription'],
				':price' 				=> $data['inputPrice'],
				':sale_price' 			=> $data['inputSalePrice'],
				':optional_name'		=> $data['inputNameSp'],
				':optional_description' => $data['inputDescriptionSp'],
				'productId'				=> $data['productId']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return [ TRUE, $data['productId'] ];
		}
	}