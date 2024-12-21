<?php
	
	namespace App\Config;
	
	use PDO;
	use PDOException;
	
	abstract class DAO
	{
		private static string $host = 'mysql:host=127.0.0.1;port=3306;charset=utf8';
		private static string $dbname = 'gestion_serpents';
		private static string $dbuser = 'Mamath68200';
		private static string $dbpass = 'Teutin@181166';
		
		/**
		 * @var PDO?
		 */
		public static $bdd;
		
		/**
		 * Connexion à la base de données.
		 *
		 * @return void
		 */
		public static function connect() : void
		{
			if( self::$bdd === null ) {
				try {
					self::$bdd = new PDO(
						self::$host . ';dbname=' . self::$dbname,
						self::$dbuser,
						self::$dbpass,
						[
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						],
					);
				} catch( PDOException $e ) {
					error_log( $e->getMessage() );
					die( 'Une erreur est survenue lors de la connexion à la base de données.' );
				}
			}
		}
		
		/**
		 * Exécute une requête d'insertion.
		 *
		 * @param string $sql    La requête SQL.
		 * @param array  $params Les paramètres de la requête.
		 *
		 * @return int|null L’identifiant de l’enregistrement inséré ou null en cas d'erreur.
		 */
		public static function insert( string $sql, array $params = [] ) : ?int
		{
			try {
				$stmt = self::$bdd->prepare( $sql );
				$stmt->execute( $params );
				return self::$bdd->lastInsertId();
			} catch( PDOException $e ) {
				error_log( $e->getMessage() );
				return null;
			}
		}
		
		/**
		 * Exécute une requête de mise à jour.
		 *
		 * @param string $sql    La requête SQL.
		 * @param array  $params Les paramètres de la requête.
		 *
		 * @return bool True en cas de succès, false sinon.
		 */
		public static function update( string $sql, array $params = [] ) : bool
		{
			try {
				$stmt = self::$bdd->prepare( $sql );
				return $stmt->execute( $params );
			} catch( PDOException $e ) {
				error_log( $e->getMessage() );
				return false;
			}
		}
		
		/**
		 * Exécute une requête de suppression.
		 *
		 * @param string $sql    La requête SQL.
		 * @param array  $params Les paramètres de la requête.
		 *
		 * @return bool True en cas de succès, false sinon.
		 */
		public static function delete( string $sql, array $params = [] ) : bool
		{
			try {
				$stmt = self::$bdd->prepare( $sql );
				return $stmt->execute( $params );
			} catch( PDOException $e ) {
				error_log( $e->getMessage() );
				return false;
			}
		}
		
		/**
		 * Exécute une requête de sélection.
		 *
		 * @param string $sql      La requête SQL.
		 * @param array  $params   Les paramètres de la requête.
		 * @param bool   $multiple True pour récupérer plusieurs résultats, false pour un seul.
		 *
		 * @return array|null Le résultat de la requête ou null en cas d'erreur.
		 */
		public static function select( string $sql, array $params = [], bool $multiple = true ) : ?array
		{
			try {
				$stmt = self::$bdd->prepare( $sql );
				$stmt->execute( $params );
				$results = $multiple ? $stmt->fetchAll() : $stmt->fetch();
				$stmt->closeCursor();
				return $results ? : [];
			} catch( PDOException $e ) {
				error_log( $e->getMessage() );
				return [];
			}
		}
	}
