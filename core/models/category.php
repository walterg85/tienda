<?php
	class Categorymodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

		public function get() {
			$pdo = new Conexion();
			$cmd = 'SELECT id, name, thumbnail, parent FROM category WHERE active = 1;';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function register($name, $visible){
	    	$pdo = new Conexion();
	    	$cmd = '
	    		INSERT INTO category (name, parent, active) VALUES (:name, :parent, 1)
	    	';

	    	$parametros = array(
	    		':name' => $name,
	    		':parent' => $visible
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

	    public function unVisivility($categoryId, $visible){
	    	$pdo = new Conexion();
	    	$cmd = '
	    		UPDATE category SET parent =:visible WHERE id =:categoryId
	    	';

	    	$parametros = array(
	    		':categoryId' => $categoryId,
	    		':visible' => $visible
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
	    }
	}