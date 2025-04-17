<?php
	
	namespace Config;
	
	class Controller
	{
		public function render( string $view, array $params = [] ) : void
		{
			extract( $params, EXTR_SKIP );
			
			$viewPath = VIEW_DIR . "/$view.html.php";
			
			if( !file_exists( $viewPath ) ) {
				http_response_code( 500 );
				$this->renderError( 500, ["title" => "Erreur 500 - Page non disponible."] );
				return;
			}
			
			ob_start();
			require $viewPath;
			$content = ob_get_clean();
			
			require_once VIEW_DIR . "/layout/base.html.php";
		}
		
		public function renderError( int $code, array $params = [] ) : void
		{
			$params['code'] = $code;
			extract( $params, EXTR_SKIP );
			
			$errorView = VIEW_DIR . "/errors/$code.html.php";
			if( !file_exists( $errorView ) ) {
				echo "Erreur $code - Page non disponible.";
				return;
			}
			
			extract( $params );
			require $errorView;
		}
		
	}
