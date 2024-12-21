<?php
	
	namespace App\Model\Managers;
	
	use App\Config\DAO;
	use App\Config\Manager;
	use DateTime;
	
	class SerpentsManager extends Manager
	{
		
		/**
		 * @var string
		 */
		protected string $className = "App\Model\Entities\Serpents";
		/**
		 * @var string
		 */
		protected string $tableName = "serpents";
		
		public function __construct()
		{
			parent::connect();
		}
		
		/**
		 * @param $id
		 *
		 * @return object|false
		 */
		public function findOneById( $id ) : object | false
		{
			$sql = "SELECT * FROM $this->tableName s WHERE s.id = :id";
			$result = DAO::select( $sql, ['id' => $id], false );
			
			if( $result ) {
				return $this->getOneOrNullResult( $result, $this->className );
			} else {
				return false;
			}
		}
		
		/**
		 * @param int              $id
		 * @param string           $nom
		 * @param int              $poids
		 * @param int              $lifestamp
		 * @param DateTime|string  $birthdate
		 * @param DateTime|string $birthhoure
		 * @param string           $race
		 * @param string           $genre
		 *
		 * @return void
		 */
		public function updateOnByID( int $id, string $nom, int $poids, int $lifestamp, DateTime|string $birthdate, DateTime|string $birthhoure, string $race, string $genre ) : void
		{
			$sql = "UPDATE $this->tableName s SET s.nom = :nom, s.poids = :poids, s.lifestamp = :lifestamp, s.birthdate = :birthdate, s.birthhoure = :birthhoure ,s.race = :race, s.genre = :genre WHERE s.id = :id";
			DAO::update( $sql, [
				'id' => $id,
				'nom' => $nom,
				'poids' => $poids,
				'birthdate' => $birthdate,
				'birthhoure' => $birthhoure,
				'race' => $race,
				'genre' => $genre,
				'lifestamp' => $lifestamp
			] );
		}
	}
