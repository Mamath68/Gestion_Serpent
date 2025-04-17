<?php
	namespace Class;
	
	use Config\Database;
	use DateMalformedStringException;
	use PDO;
	
	require_once "Snake.php";
	
	class SnakeManager
	{
		private ?PDO $pdo;
		
		public function __construct()
		{
			$this->pdo = Database::getInstance()->pdo;
		}
		
		public function getAll( $filters = [], $orderBy = 'id', $orderDirection = 'asc', $offset = 0, $limit = 10 ) : array
		{
			$sql = "SELECT * FROM snakes";
			$params = [];
			
			if( !empty( $filters ) ) {
				$sql .= " WHERE 1=1";
				
				if( !empty( $filters['gender'] ) ) {
					$sql .= " AND gender = :gender";
					$params[':gender'] = $filters['gender'];
				}
				
				if( !empty( $filters['breed'] ) ) {
					$sql .= " AND breed = :breed";
					$params[':breed'] = $filters['breed'];
				}
				
				// if (!empty($filters['min_weight']) && !empty($filters['max_weight'])) {
				//   $sql .= " AND weight BETWEEN :min_weight AND :max_weight";
				//   $params[':min_weight'] = $filters['min_weight'];
				//   $params[':max_weight'] = $filters['max_weight'];
				// } elseif (!empty($filters['min_weight'])) {
				//   $sql .= " AND weight >= :min_weight";
				//   $params[':min_weight'] = $filters['min_weight'];
				// } elseif (!empty($filters['max_weight'])) {
				//   $sql .= " AND weight <= :max_weight";
				//   $params[':max_weight'] = $filters['max_weight'];
				// }
				
				// if (isset($filters['is_dead'])) {
				//   $sql .= " AND is_dead = :is_dead";
				//   // 1 pour mort, 0 pour vivant
				//   $params[':is_dead'] = $filters['is_dead'] ? 1 : 0;
				// }
			}
			
			$sql .= " ORDER BY $orderBy $orderDirection LIMIT $offset, $limit";
			
			$stmt = $this->pdo->prepare( $sql );
			$stmt->execute( $params );
			
			return array_map( /**
			 * @throws DateMalformedStringException
			 */ fn( $s ) => new Snake( $s ), $stmt->fetchAll( PDO::FETCH_ASSOC ) );
		}
		
		public function getTotalCount( $filters = [] )
		{
			$sql = "SELECT COUNT(*) FROM snakes";
			$params = [];
			
			if( !empty( $filters ) ) {
				$sql .= " WHERE 1=1";
				if( !empty( $filters['gender'] ) ) {
					$sql .= " AND gender = :gender";
					$params[':gender'] = $filters['gender'];
				}
				if( !empty( $filters['breed'] ) ) {
					$sql .= " AND breed LIKE :breed";
					$params[':breed'] = '%' . $filters['breed'] . '%';
				}
			}
			
			$stmt = $this->pdo->prepare( $sql );
			$stmt->execute( $params );
			
			return $stmt->fetchColumn();
		}
		
		public function add( snake $snake ) : void
		{
			$stmt = $this->pdo->prepare( "INSERT INTO snakes (name, weight, lifespan, birth_date, breed, gender, father_id, mother_id, is_dead)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)" );
			$stmt->execute( [
				$snake->name,
				$snake->weight,
				$snake->lifespan,
				$snake->birth_date,
				$snake->breed,
				$snake->gender,
				$snake->father_id,
				$snake->mother_id,
				$snake->is_dead
			] );
		}
		
		public function update( snake $snake ) : void
		{
			$stmt = $this->pdo->prepare( "UPDATE snakes SET name = ?, weight = ?, lifespan = ?, birth_date = ?, breed = ?, gender = ?, father_id = ?, mother_id = ?, is_dead = ? WHERE id = ?" );
			$stmt->execute( [
				$snake->name,
				$snake->weight,
				$snake->lifespan,
				$snake->birth_date,
				$snake->breed,
				$snake->gender,
				$snake->father_id,
				$snake->mother_id,
				$snake->is_dead,
				$snake->id
			] );
		}
		
		public function delete( $id ) : void
		{
			$stmt = $this->pdo->prepare( "DELETE FROM snakes WHERE id = ?" );
			$stmt->execute( [$id] );
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function getById( $id ) : ?snake
		{
			$stmt = $this->pdo->prepare( "SELECT * FROM snakes WHERE id = ?" );
			$stmt->execute( [$id] );
			$data = $stmt->fetch( PDO::FETCH_ASSOC );
			return $data ? new snake( $data ) : null;
		}
		
		public function getChildren( $id ) : array
		{
			$stmt = $this->pdo->prepare( "SELECT * FROM snakes WHERE father_id = :id OR mother_id = :id" );
			$stmt->execute( ['id' => $id] );
			
			$data = $stmt->fetchAll( PDO::FETCH_ASSOC );
			
			return array_map( /**
			 * @throws DateMalformedStringException
			 */ fn( $s ) => new Snake( $s ), $data );
		}
		
		public function getSiblings( $selfId, $fatherId, $motherId ) : array
		{
			$stmt = $this->pdo->prepare( "SELECT * FROM snakes WHERE father_id = :father AND mother_id = :mother AND id != :self" );
			$stmt->execute( ['father' => $fatherId, 'mother' => $motherId, 'self' => $selfId] );
			
			$data = $stmt->fetchAll( PDO::FETCH_ASSOC );
			
			return array_map( /**
			 * @throws DateMalformedStringException
			 */ fn( $s ) => new Snake( $s ), $data );
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function getUnclesAndAunts( $snake ) : array
		{
			$results = [];
			if( $snake->father_id ) {
				$father = $this->getById( $snake->father_id );
				if( $father ) {
					$results = array_merge( $results, $this->getSiblings( $father->id, $father->father_id, $father->mother_id ) );
				}
			}
			if( $snake->mother_id ) {
				$mother = $this->getById( $snake->mother_id );
				if( $mother ) {
					$results = array_merge( $results, $this->getSiblings( $mother->id, $mother->father_id, $mother->mother_id ) );
				}
			}
			return $results;
		}
		
		public function generateRandomSnakes( $count = 5 ) : void
		{
			$names = ['Slytherin', 'Viper', 'Python', 'Boa', 'Cobra', 'Anaconda'];
			$breeds = ['Royal Python', 'Corn Snake', 'Boa Constrictor', 'King Cobra', 'Green Anaconda'];
			$genders = ['male', 'female'];
			$lifespan = [5, 10, 15, 20, 25];
			$weights = [1, 2, 3, 4, 5, 6, 7, 8];
			
			for( $i = 0 ; $i < $count ; $i++ ) {
				$name = $names[ array_rand( $names ) ];
				$breed = $breeds[ array_rand( $breeds ) ];
				$gender = $genders[ array_rand( $genders ) ];
				$life = $lifespan[ array_rand( $lifespan ) ];
				$weight = $weights[ array_rand( $weights ) ];
				$isDead = rand( 0, 1 ) === 1;
				
				$sql = "INSERT INTO snakes (name, breed, gender, lifespan, weight, is_dead)
              VALUES (:name, :breed, :gender, :lifespan, :weight, :is_dead)";
				$stmt = $this->pdo->prepare( $sql );
				$stmt->execute( [
					':name' => $name,
					':breed' => $breed,
					':gender' => $gender,
					':lifespan' => $life,
					':weight' => $weight,
					':is_dead' => $isDead
				] );
			}
		}
		
		public function getAllBreeds() : array
		{
			$query = 'SELECT DISTINCT breed FROM snakes';
			$stmt = $this->pdo->prepare( $query );
			$stmt->execute();
			return $stmt->fetchAll( PDO::FETCH_COLUMN );
		}
	}
