<?php
	
	namespace App\Config;
	
	class Autoloader
	{
		/**
		 * Enregistre l'autoloader.
		 *
		 * @return void
		 */
		public static function register() : void
		{
			spl_autoload_register( [__CLASS__, 'autoload'] );
		}
		
		/**
		 * Charge automatiquement les classes selon leur nom complet.
		 *
		 * @param string $class Le nom complet de la classe (avec namespace)
		 * @return void
		 */
		public static function autoload( string $class ) : void
		{
			// Remplace les backslashes par le séparateur de dossier et met en minuscules le namespace
			$parts = preg_split( '#\\\#', $class );
			$className = array_pop( $parts );
			$path = strtolower( implode( DIRECTORY_SEPARATOR, $parts ) );
			
			// Construit le chemin complet du fichier
			$filePath = BASE_DIR . $path . DIRECTORY_SEPARATOR . $className . '.php';
			
			// Vérifie si le fichier existe
			if( file_exists( $filePath ) ) {
				require $filePath;
			} else {
				// Gestion d'erreur avec message détaillé
				error_log( "Autoloader : Impossible de charger la classe '$class' dans le chemin attendu '$filePath'" );
			}
		}
	}
