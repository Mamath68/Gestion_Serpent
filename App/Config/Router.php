<?php
	
	namespace App\Config;
	
	
	use App\Class\Controllers\SnakeController;
	
	class Router
	{
		private SnakeController $snakeController;
		
		public function __construct()
		{
			$this->snakeController = new SnakeController();
		}
		
		public function routes() : void
		{
			$pageNumber = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$page = $pageNumber ?? 'list';
			
			switch( $page ) {
				case 'list':
					$this->snakeController->index();
					break;
				case 'genealogy':
					$this->snakeController->show();
					break;
				case 'breed':
					$this->snakeController->breed();
					break;
				case 'add':
					$this->snakeController->add();
					break;
				case 'edit':
					$this->snakeController->edit();
					break;
				case 'delete':
					$this->snakeController->delete();
				default:
					http_response_code( 404 );
					$this->snakeController->renderError( 404, ['title' => 'Page non trouvée'] );
					break;
			}
		}
	}
