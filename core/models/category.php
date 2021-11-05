<?php
	class Categorymodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

		public function get() {
			$pdo = new Conexion();
			$cmd = 'SELECT id, name, thumbnail FROM category WHERE active = 1;';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function register($name){
	    	$pdo = new Conexion();
	    	$cmd = '
	    		INSERT INTO category (name, active) VALUES (:name, 1)
	    	';

	    	$parametros = array(
	    		':name' => $name
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $pdo->lastInsertId();
	    }

	    public function delete($categoryId){
	    	$pdo = new Conexion();
	    	$cmd = '
	    		UPDATE category SET active = 0 WHERE id =:categoryId
	    	';

	    	$parametros = array(
	    		':categoryId' => $categoryId
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
	    }

	    public function updateThumbnail($categoryId, $thumbnail){
	    	$pdo = new Conexion();
			$cmd = 'UPDATE category SET thumbnail =:thumbnail WHERE id =:categoryId';

			$parametros = array(
				':thumbnail' => $thumbnail,
				':categoryId' => $categoryId			
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
	    }
	}