<?php
	
	use Config\Database;
	use Config\Controller;
	use Class\SnakeManager;
	use Config\SessionManager;
	
	require __DIR__ . '/../vendor/autoload.php';
	const STYLE_DIR = "../assets/css";
	const SCRIPT_DIR = "../assets/js";
	const VIEW_DIR = __DIR__ . "/../views";
	
	SessionManager::start();
	
	$controller = new Controller();
	$db = Database::getInstance()->pdo;
	
	$manager = new SnakeManager();
	
	$page = $_GET['page'] ?? 'list';
	
	switch( $page ) {
		
		case 'list':
			$controller->render( 'pages/list', ['title' => 'Liste des serpents'] );
			break;
		
		case 'breed':
			$controller->render( 'pages/breed', ['title' => 'Accouplement des Serpents'] );
			break;
		
		case 'genealogy':
			
			$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ) ?? null;
			try {
				$snake = $manager->getById( $id );
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
			if( $id === null ) {
				http_response_code( 400 );
				$controller->renderError( 400, ['title' => 'Paramètre manquant'] );
				break;
			}
			
			try {
				$controller->render( 'pages/genealogy', [
					'title' => "Généalogie de: " . $snake->name,
					'id' => $manager->getById( $id )
				] );
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
			break;
		
		case 'add':
			$controller->render( 'Forms/add', ['title' => 'Donnez vie à un nouveau Serpent!'] );
			break;
		
		case 'edit':
			$id = $_GET['id'] ?? null;
			if( !$id ) {
				http_response_code( 400 );
				$controller->renderError( 400, ['title' => 'ID manquant'] );
				break;
			}
			$controller->render( 'Forms/edit', ['title' => 'Éditer un Serpent', 'id' => $id] );
			break;
		
		
		case 'delete':
			$id = $_GET['id'] ?? null;
			if( !$id ) {
				http_response_code( 400 );
				$controller->renderError( 400, ['title' => 'ID manquant'] );
				break;
			}
			$controller->render( 'Forms/delete', ['title' => 'Suppression d\'un Serpent', 'id' => $id] );
			break;
		
		default:
			http_response_code( 404 );
			$controller->renderError( 404, ['title' => 'Page non trouvée'] );
			break;
	}
