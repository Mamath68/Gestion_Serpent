<?php
	
	namespace Config;
	
	use PDO;
	use PDOException;
	
	class Database
	{
		private static ?Database $instance = null;
		/**
		 * @var PDO
		 */
		public PDO $pdo {
			get {
				return $this->pdo;
			}
		}
		
		private function __construct()
		{
			$dbhost = "127.0.0.1";
			$dbport = 3306;
			$dbname = "snakes_db";
			$dbuser = "Mamath68200";
			$dbpass = "Teutin@181166";
			$dbcharset = "utf8";
			
			try {
				$this->pdo = new PDO( "mysql:host=$dbhost;port=$dbport;dbname=$dbname;charset=$dbcharset", $dbuser, $dbpass, [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				] );
			} catch( PDOException $e ) {
				die( "Erreur de connexion à la base de données: " . $e->getMessage() );
			}
		}
		
		public static function getInstance() : Database
		{
			if( self::$instance === null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		
	}
