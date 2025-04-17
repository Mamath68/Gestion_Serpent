<?php
	
	namespace App\Class\Controllers;
	
	use App\Class\Managers\SnakeManager;
	use App\Config\Controller;
	use DateMalformedStringException;
	
	class SnakeController extends Controller
	{
		private SnakeManager $manager;
		
		public function __construct()
		{
			$this->manager = new SnakeManager();
		}
		
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
			
			$orderBy = $_GET['sort'] ?? 'id';
			$orderDirection = isset( $_GET['order'] ) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
			
			$side = isset( $_GET['side'] ) ? (int) $_GET['side'] : 1;
			$itemsPerPage = 10;
			$offset = ( $side - 1 ) * $itemsPerPage;
			
			$snakes = $this->manager->getAll( $filters, $orderBy, $orderDirection, $offset, $itemsPerPage );
			
			$maleCount = count( array_filter( $snakes, fn( $s ) => $s->gender === 'Mâle' ) );
			$femaleCount = count( $snakes ) - $maleCount;
			
			$totalMales = $this->manager->getTotalCount( array_merge( $filters, ['gender' => 'Male'] ) );
			$totalFemales = $this->manager->getTotalCount( array_merge( $filters, ['gender' => 'Femelle'] ) );
			
			$totalSnakes = $this->manager->getTotalCount( $filters );
			$totalPages = ceil( $totalSnakes / $itemsPerPage );
			$this->render( 'pages/list', [
				'title' => 'Liste des serpents',
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

// Méthode récursive pour récupérer les ancêtres
		
		/**
		 * @throws DateMalformedStringException
		 */
		private function collectAncestors( ?int $id, array &$result, int $level = 1 ) : void
		{
			if( !$id ) return;
			$ancestor = $this->manager->getById( $id );
			if( $ancestor ) {
				$result[] = ['level' => $level, 'snake' => $ancestor];
				$this->collectAncestors( $ancestor->father_id, $result, $level + 1 );
				$this->collectAncestors( $ancestor->mother_id, $result, $level + 1 );
			}
		}

// Méthode récursive pour récupérer les descendants
		private function collectDescendants( int $id, array &$result, int $level = 1 ) : void
		{
			$children = $this->manager->getChildren( $id );
			foreach( $children as $child ) {
				$result[] = ['level' => $level, 'snake' => $child];
				$this->collectDescendants( $child->id, $result, $level + 1 );
			}
		}
		
		public function breed() : void
		{
			$this->render( 'pages/breed', ['title' => 'Accouplement des Serpents'] );
		}
		
		public function add() : void
		{
			$this->render( 'Forms/add', ['title' => 'Donnez vie à un nouveau Serpent!'] );
		}
		
		public function edit() : void
		{
			$id = $_GET['id'] ?? null;
			if( !$id ) {
				http_response_code( 400 );
				$this->renderError( 400, ['title' => 'ID manquant'] );
				return;
			}
			
			$this->render( 'Forms/edit', ['title' => 'Éditer un Serpent', 'id' => $id] );
		}
		
		public function delete() : void
		{
			$id = $_GET['id'] ?? null;
			if( !$id ) {
				http_response_code( 400 );
				$this->renderError( 400, ['title' => 'ID manquant'] );
				return;
			}
			
			$this->render( 'Forms/delete', ['title' => 'Suppression d\'un Serpent', 'id' => $id] );
		}
	}
