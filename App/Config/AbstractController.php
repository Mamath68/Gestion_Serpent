<?php
	
	namespace App\Config;
	
	abstract class AbstractController
	{
		
		
		/**
		 * @return $this
		 */
		public function index() : mixed
		{
			return $this;
		}
		
		/**
		 * @param string $viewName
		 * @param array  $data
		 *
		 * @return array{view: string, data: array}
		 */
		public function render( string $viewName, array $data = [] ) : array
		{
			// Ajoute l'extension .html.php automatiquement
			$viewPath = VIEW_DIR . $viewName . '.html.php';
			
			return [
				"view" => $viewPath,
				"data" => $data
			];
		}
		
		/**
		 * Redirige vers une autre route.
		 *
		 * @param string|null     $ctrl   Le contrôleur cible
		 * @param string|null     $action L’action cible
		 * @param int|string|null $id     L’identifiant de la ressource
		 */
		public function redirectTo( string $ctrl = null, string $action = null, int | string $id = null ) : void
		{
			$url = http_build_query( array_filter( [
				'ctrl' => $ctrl,
				'action' => $action,
				'id' => $id,
			] ) );
			
			var_dump( $url ); // Vérifie si l'URL inclut l'ID
			header( "Location: ?$url" );
			die();
		}
		
		
		/**
		 * @return void
		 */
		public function redirectHome() : void
		{
			$this->redirectTo( "home", "index" );
		}
		
	}
