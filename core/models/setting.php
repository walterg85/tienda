<?php
	class Settingsmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

		public function get() {
			$pdo = new Conexion();
			$cmd = 'SELECT parameter, value FROM setting';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}		
	}