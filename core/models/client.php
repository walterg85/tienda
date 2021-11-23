<?php
	class Clientmodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client
						(nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional, registro, estatus)
				VALUES
					(:nombre, :apellido, :direccion_a, :direccion_b, :telefono, :ciudad, :estado, :codigo_postal, :adicional, now(), 1)
			';

			$parametros = array(
				':nombre' 			=> $data['inputName'],
				':apellido' 		=> $data['inputLastname'],
				':direccion_a' 		=> $data['inputAddress'],
				':direccion_b' 		=> $data['inputAddress2'],
				':telefono'			=> $data['inputPhone'],
				':ciudad' 			=> $data['inputCity'],
				':estado'			=>  $data['inputState'],
				':codigo_postal'	=>  $data['inputZip'],
				':adicional'		=>  $data['inputInfo']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }
		}
	}