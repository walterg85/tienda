<?php
	class Usersmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

		public function createUser($userData) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO user
					(owner, email, password, type, register_date, oauth_provider, active)
				VALUES
					(:owner, :email, :password, :type, now(), "system", 1)
			';

			$parametros = array(
				':owner' => $userData['owner'],
				':email' => $userData['email'],
				':password' => $userData['password'],
				':type' => $userData['type']
			);
			
			try {
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);

				return [TRUE, $pdo->lastInsertId()];
			} catch (PDOException $e) {
		        return [FALSE, $e->getCode()];
		    }
		}

		public function login($uname) {
			$pdo = new Conexion();
			$cmd = 'SELECT id, email, password, type FROM user WHERE owner =:uname AND active = 1';

			$parametros = array(
				':uname' => $uname
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}		
	}