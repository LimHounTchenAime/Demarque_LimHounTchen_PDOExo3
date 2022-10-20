<?php
	namespace Factory;
	use PDO;
	class ConnectionFactory
	{
		static $conn = [];

		static function setConfig(){
			self::$conn = parse_ini_file('db.conf.ini');
		}

		static function connexion(){
			$dsn=self::$conn['driver'].':host='.self::$conn['host'].'; dbname='.self::$conn['database'];

			return new PDO($dsn,self::$conn['username'],self::$conn['password']);

		}

		function getDB() : string{
			return self::$conn['database'];
		}
	}
?>