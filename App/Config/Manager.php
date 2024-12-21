<?php
	
	namespace App\Config;
	
	use Exception;
	use PDOException;
	
	abstract class Manager
	{
		
		protected string $tableName;
		protected string $className;
		
		
		/**
		 * @return void
		 */
		protected function connect() : void
		{
			DAO::connect();
		}
		
		/**
		 * Récupère tous les enregistrements d'une table, triés par un champ et un ordre optionnels.
		 *
		 * @param array|null $order Tableau contenant le champ de tri et l’ordre (asc/desc).
		 *
		 * @return iterable Collection d'objets hydratés, résultats de la requête.
		 */
		public function findAll( array $order = null ) : iterable
		{
			$orderQuery = $order ? "ORDER BY " . $order[0] . " " . $order[1] : "";
			$sql = "SELECT * FROM " . $this->tableName . " a " . $orderQuery;
			return $this->getMultipleResults(
				DAO::select( $sql ),
				$this->className,
			);
		}
		
		/**
		 * Récupère un enregistrement par son identifiant.
		 *
		 * @param int $id L'identifiant de l'enregistrement.
		 *
		 * @return object|false L’objet hydraté ou false si aucun enregistrement trouvé.
		 */
		public function findOneById( int $id ) : object | false
		{
			$sql = "SELECT * FROM " . $this->tableName . " a WHERE a.id_" . $this->tableName . " = :id";
			return $this->getOneOrNullResult(
				DAO::select( $sql, ['id' => $id], false ),
				$this->className,
			);
		}
		
		/**
		 * Ajoute un nouvel enregistrement dans la table.
		 *
		 * @param array $data Tableau associatif des données à insérer.
		 *
		 * @return int|null L’identifiant de l’enregistrement ajouté ou null en cas d'erreur.
		 * @throws Exception
		 */
		public function add( array $data ) : ?int
		{
			$keys = array_keys( $data );
			$placeholders = implode( ',', array_fill( 0, count( $data ), '?' ) );
			$sql = "INSERT INTO " . $this->tableName . " (" . implode( ',', $keys ) . ") VALUES (" . $placeholders . ")";
			
			try {
				return DAO::insert( $sql, array_values( $data ) );
			} catch( PDOException $e ) {
				error_log( "Erreur lors de l'ajout d'un enregistrement: " . $e->getMessage() );
				throw new Exception( "Erreur lors de l'ajout des données." );
			}
		}
		
		/**
		 * Supprime un enregistrement par son identifiant.
		 *
		 * @param int $id L’identifiant de l’enregistrement à supprimer.
		 *
		 * @return bool True si la suppression a réussi, false sinon.
		 */
		public function delete(
			int $id ) : bool
		{
			$sql = "DELETE FROM " . $this->tableName . " WHERE id_" . $this->tableName . " = :id";
			return DAO::delete( $sql, ['id' => $id] );
		}
		
		/**
		 * Génère des instances d'objet à partir des lignes de résultats.
		 *
		 * @param iterable $rows  Les lignes de résultats.
		 * @param string   $class Le nom de la classe des objets à créer.
		 *
		 * @return iterable Collection d'objets.
		 */
		private function generate(
			iterable $rows, string $class ) : iterable
		{
			foreach( $rows as $row ) {
				yield new $class( $row );
			}
		}
		
		/**
		 * Convertis des lignes de résultats en instances d'objets.
		 *
		 * @param iterable $rows  Les lignes de résultats.
		 * @param string   $class Le nom de la classe des objets à créer.
		 *
		 * @return iterable|null Collection d'objets ou null si aucun résultat.
		 */
		protected function getMultipleResults(
			iterable $rows, string $class ) : ?iterable
		{
			return $this->generate( $rows, $class );
		}
		
		/**
		 * Crée une instance d'objet à partir d'une ligne de résultat ou retourne false.
		 *
		 * @param array|null $row   La ligne de résultat.
		 * @param string     $class Le nom de la classe de l’objet à créer.
		 *
		 * @return object|false L’objet hydraté ou false.
		 */
		protected function getOneOrNullResult(
			?array $row, string $class ) : object | false
		{
			return $row ? new $class( $row ) : false;
		}
		
		/**
		 * Récupère une valeur scalaire à partir d'une ligne de résultat.
		 *
		 * @param array|null $row La ligne de résultat.
		 *
		 * @return mixed|false La valeur scalaire ou false.
		 */
		protected function getSingleScalarResult(
			?array $row ) : mixed
		{
			return $row ? array_values( $row )[0] : false;
		}
	}
