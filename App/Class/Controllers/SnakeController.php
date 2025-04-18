<?php
	
	namespace App\Class\Controllers;
	
	use App\Class\Entities\GenealogyEntry;
	use App\Class\Entities\Snake;
	use App\Class\Managers\SnakeManager;
	use App\Config\Controller;
	use DateMalformedStringException;
	use JetBrains\PhpStorm\NoReturn;
	
	class SnakeController extends Controller
	{
		/**
		 * @var SnakeManager
		 */
		private SnakeManager $manager;
		/**
		 * @var Ecosystem
		 */
		private Ecosystem $ecosystem;
		
		public function __construct()
		{
			$this->manager = new SnakeManager();
			$this->ecosystem = new Ecosystem();
		}
		
		/**
		 * Afficher les Serpents
		 */
		public function index() : void
		{
			$allBreeds = $this->manager->getAllBreeds();
			$breeded = filter_input( INPUT_GET, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$genre = filter_input( INPUT_GET, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$breed = filter_input( INPUT_GET, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$min_weight = filter_input( INPUT_GET, 'min_weight', FILTER_SANITIZE_NUMBER_FLOAT );
			$max_weight = filter_input( INPUT_GET, 'max_weight', FILTER_SANITIZE_NUMBER_FLOAT );
			$status = filter_input( INPUT_GET, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$filters = [];
			if( isset( $genre ) && in_array( $genre, ['Male', 'Femelle'] ) ) {
				$filters['gender'] = $genre;
			}
			if( !empty( $breed ) ) {
				$filters['breed'] = $breed;
			}
			if( isset( $min_weight ) && is_numeric( $min_weight ) ) {
				$filters['weight_min'] = $min_weight;
			}
			if( isset( $max_weight ) && is_numeric( $max_weight ) ) {
				$filters['weight_max'] = $max_weight;
			}
			if( isset( $status ) && in_array( $status, ['alive', 'dead'] ) ) {
				$filters['status'] = $status;
			}
			$sort = filter_input( INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$order = filter_input( INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$side = filter_input( INPUT_GET, 'side', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$orderBy = $sort ?? 'id';
			$orderDirection = isset( $order ) && $order === 'desc' ? 'desc' : 'asc';
			
			$side = isset( $side ) ? (int) $side : 1;
			$itemsPerPage = 10;
			$offset = ( $side - 1 ) * $itemsPerPage;
			
			$snakes = $this->manager->getAll( $filters, $orderBy, $orderDirection, $offset, $itemsPerPage );
			
			$maleCount = count( array_filter( $snakes, fn( $s ) => $s->gender === 'Male' ) );
			$femaleCount = count( $snakes ) - $maleCount;
			
			$totalMales = $this->manager->getTotalCount( array_merge( $filters, ['gender' => 'Male'] ) );
			$totalFemales = $this->manager->getTotalCount( array_merge( $filters, ['gender' => 'Femelle'] ) );
			
			$totalSnakes = $this->manager->getTotalCount( $filters );
			$totalPages = ceil( $totalSnakes / $itemsPerPage );
			$this->render( 'pages/list', [
				'title' => 'Vivarium STAMM',
				'snakes' => $snakes,
				'allBreeds' => $allBreeds,
				'genre' => $genre,
				'breeded' => $breeded,
				'breed' => $breed,
				'min_weight' => $min_weight,
				'max_weight' => $max_weight,
				'status' => $status,
				'orderBy' => $orderBy,
				'orderDirection' => $orderDirection,
				'side' => $side,
				'itemsPerPage' => $itemsPerPage,
				'totalMales' => $totalMales,
				'totalFemales' => $totalFemales,
				'totalSnakes' => $totalSnakes,
				'totalPages' => $totalPages,
				'offset' => $offset,
				'femaleCount' => $femaleCount,
				'maleCount' => $maleCount,
			] );
		}
		
		/**
		 * Afficher le détail d'un Serpent
		 */
		public function show() : void
		{
			$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
			if( !$id ) {
				http_response_code( 400 );
				$this->renderError( 400, ['title' => 'Paramètre manquant'] );
				return;
			}
			
			try {
				$snake = $this->manager->getById( $id );
				
				if( !$snake ) {
					http_response_code( 404 );
					$this->renderError( 404, ['title' => 'Serpent introuvable'] );
					return;
				}
				
				// Récupération des ancêtres
				$ancestors = [];
				$this->collectAncestors( $snake->father_id, $ancestors );
				$this->collectAncestors( $snake->mother_id, $ancestors );
				
				// Récupération des descendants
				$descendants = [];
				$this->collectDescendants( $snake->id, $descendants );
				
				// Frères et sœurs
				$siblings = ( $snake->father_id && $snake->mother_id )
					? $this->manager->getSiblings( $snake->id, $snake->father_id, $snake->mother_id )
					: [];
				
				// Oncles et tantes
				$unclesAunts = $this->manager->getUnclesAndAunts( $snake );
				
				$this->render( 'pages/genealogy', [
					'title' => "Généalogie de: " . $snake->name,
					'snake' => $snake,
					'ancestors' => $ancestors,
					'descendants' => $descendants,
					'siblings' => $siblings,
					'unclesAunts' => $unclesAunts
				] );
				
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
		}
		
		/**
		 * Ajouter un Serpent
		 */
		public function add() : void
		{
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$weight = filter_input( INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT );
				$lifespan = filter_input( INPUT_POST, 'lifespan', FILTER_SANITIZE_NUMBER_INT );
				$birthday = filter_input( INPUT_POST, 'birth_date' );
				$breed = filter_input( INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$gender = filter_input( INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$father_id = filter_input( INPUT_POST, 'father_id', FILTER_VALIDATE_INT );
				$mother_id = filter_input( INPUT_POST, 'mother_id', FILTER_VALIDATE_INT );
				$data = [
					'name' => $name,
					'weight' => $weight,
					'lifespan' => $lifespan,
					'birth_date' => $birthday,
					'breed' => $breed,
					'gender' => $gender,
					'father_id' => $father_id ?? null,
					'mother_id' => $mother_id ?? null,
					'is_dead' => false
				];
				try {
					$this->manager->add( new Snake( $data ) );
				} catch( DateMalformedStringException $e ) {
					echo $e->getMessage();
				}
				header( "Location: index.php?page=list" );
				exit;
			}
			$this->render( 'Forms/add', ['title' => 'Donnez vie à un nouveau Serpent!'] );
		}
		
		/**
		 * Editer un Serpent
		 *
		 */
		public function edit() : void
		{
			$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
			try {
				$snake = isset( $id ) ? $this->manager->getById( $id ) : null;
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
			
			if( !$snake ) {
				echo "Serpent introuvable.";
				exit;
			}
			$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$weight = filter_input( INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT );
			$lifespan = filter_input( INPUT_POST, 'lifespan', FILTER_SANITIZE_NUMBER_INT );
			$birthday = filter_input( INPUT_POST, 'birth_date' );
			$breed = filter_input( INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$gender = filter_input( INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				$snake->setName( $name );
				$snake->setWeight( $weight );
				$snake->setLifespan( $lifespan );
				$snake->setBirthDate( $birthday );
				$snake->setBreed( $breed );
				$snake->setGender( $gender );
				$manager->update( $snake );
				header( "Location: index.php?page=list" );
				exit;
			}
			if( !$id ) {
				http_response_code( 400 );
				$this->renderError( 400, ['title' => 'ID manquant'] );
				return;
			}
			
			$this->render( 'Forms/edit', [
				'title' => 'Éditer un Serpent',
				'id' => $id,
				'snake' => $snake
			] );
		}
		
		/**
		 * Accoupler 2 serpents
		 *
		 */
		public function breed() : void
		{
			$snakes = $this->manager->getAll();
			$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
			$selectedId = $id ?? null;
			
			$selectedSnake = null;
			$male = null;
			$female = null;
			$message = '';
			
			try {
				$selectedSnake = $selectedId ? $this->manager->getById( $selectedId ) : null;
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
			
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				try {
					$male_id = filter_input( INPUT_POST, 'male_id', FILTER_VALIDATE_INT );
					$female_id = filter_input( INPUT_POST, 'female_id', FILTER_VALIDATE_INT );
					$male = $this->manager->getById( $male_id );
					$female = $this->manager->getById( $female_id );
				} catch( DateMalformedStringException $e ) {
					echo $e->getMessage();
				}
				
				if( $male && $female ) {
					try {
						$baby = $this->ecosystem->breed( $male, $female );
						if( $baby ) {
							$this->manager->add( $baby );
							header( 'Location: index.php?page=list' );
							exit;
						} else {
							$message = "L'accouplement a échoué. Vérifie la compatibilité.";
						}
					} catch( DateMalformedStringException $e ) {
						echo $e->getMessage();
					}
				}
			}
			
			$this->render( 'Forms/breed', [
				'title' => 'Accouplement des Serpents',
				'snakes' => $snakes,
				'selectedSnake' => $selectedSnake,
				'message' => $message,
			] );
		}
		
		/**
		 * Supprimer un Serpent
		 */
		#[NoReturn] public function delete() : void
		{
			$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ) ?? null;
			
			if( $id ) {
				$this->manager->delete( $id );
			}
			
			header( "Location: index.php?page=list" );
			exit;
		}
		
		/**
		 * Fonctions allant avec le détail d'un serpent
		 */
		/**
		 * Récupère les Ancètres d'un Serpent
		 *
		 * @param int|null $id
		 * @param array    $result
		 * @param int      $level
		 *
		 * @throws DateMalformedStringException
		 */
		private function collectAncestors( ?int $id, array &$result, int $level = 1 ) : void
		{
			if( !$id ) return;
			$ancestor = $this->manager->getById( $id );
			if( $ancestor ) {
				$result[] = new GenealogyEntry( $level, $ancestor );
				$this->collectAncestors( $ancestor->father_id, $result, $level + 1 );
				$this->collectAncestors( $ancestor->mother_id, $result, $level + 1 );
			}
		}
		
		private function collectDescendants( int $id, array &$result, int $level = 1 ) : void
		{
			$children = $this->manager->getChildren( $id );
			foreach( $children as $child ) {
				$result[] = new GenealogyEntry( $level, $child );
				$this->collectDescendants( $child->id, $result, $level + 1 );
			}
		}
	}
