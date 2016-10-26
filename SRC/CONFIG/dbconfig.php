<?php
	namespace CONFIG;
	use \PDO;

	class DBConfig{
		private static $type;
		private static $host;
		private static $port;
		private static $username;
		private static $password;
		private static $database;

		public static function setDBConfig($database ='testowa',
			$username ='user', $password = '123456', $host = 'localhost',
			$type = 'mysql', $port = '3306'){

			DBConfig::$database = $database;
			DBConfig::$username = $username;
			DBConfig::$password = $password;
			DBConfig::$host = $host;
			DBConfig::$type = $type;
			DBConfig::$port = $port;
		}

		public static function getHandle(){
			try{
				$pdo = new PDO(DBConfig::$type.':host='.DBConfig::$host.';dbname='.DBConfig::$database.';port='.DBConfig::$port, DBConfig::$username, DBConfig::$password );
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo 'Połączenie nawiązane!<br>';
				return $pdo;

			}catch(PDOException $e){
				echo 'Połączenie nie mogło zostać utworzone.<br>';
			}
			return null;
		}
	}
