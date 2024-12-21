<?php
	
	namespace App\Config;
	
	abstract class Entity
	{
		
		/**
		 * Remplis les propriétés de l’entité en utilisant les données fournies.
		 *
		 * @param array $data Les données à hydrater.
		 *
		 * @return void
		 */
		protected function hydrate( array $data ) : void
		{
			foreach( $data as $field => $value ) {
				// Découpe le champ en utilisant '_'
				$fieldArray = explode( "_", $field );
				
				// Vérifie si le champ est un identifiant et traite les associations
				if( isset( $fieldArray[1] ) && $fieldArray[1] == "id" ) {
					// Construit le nom du gestionnaire (Manager)
					$manName = ucfirst( $fieldArray[0] ) . "Manager";
					$FQCName = "Model\Managers\\" . $manName;
					
					// Vérifie si le gestionnaire existe
					if( class_exists( $FQCName ) ) {
						$man = new $FQCName();
						
						// Vérifie si la méthode findOneById existe
						if( method_exists( $man, 'findOneById' ) ) {
							$value = $man->findOneById( $value );
						} else {
							error_log( "Méthode findOneById manquante dans $FQCName" );
						}
					} else {
						error_log( "Gestionnaire $FQCName non trouvé" );
					}
				}
				
				// Construit le nom du setter et l’appelle si la méthode existe
				$method = "set" . ucfirst( $fieldArray[0] );
				
				if( method_exists( $this, $method ) ) {
					$this->$method( $value );
				} else {
					error_log( "Méthode $method manquante dans " . get_class( $this ) );
				}
			}
		}
		
		/**
		 * Renvoie le nom complet de la classe.
		 *
		 * @return string
		 */
		public function getClass() : string
		{
			return get_class( $this );
		}
	}
