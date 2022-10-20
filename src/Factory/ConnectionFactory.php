<?php
	namespace src\Factory;
    use PDO;

	class ConnectionFactory
	{
		static $conn = [];

		static function setConfig(){
			self::$conn = parse_ini_file('db.conf.ini');
		}

		static function connexion():PDO{
			$dsn=self::$conn['driver'].':host='.self::$conn['host'].'; dbname='.self::$conn['database'];
			$pdo = new PDO($dsn,self::$conn['username'],self::$conn['password']);
			return $pdo;

		}

		function getDB() : string{
			return self::$conn['database'];
		}
	}
?>