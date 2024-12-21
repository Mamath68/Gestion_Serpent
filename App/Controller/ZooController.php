<?php
	
	namespace App\Controller;
	
	use App\Config\AbstractController;
	use App\Config\ControllerInterface;
	use App\Model\Managers\SerpentsManager;
	use DateTime;
	use Exception;
	
	class ZooController extends AbstractController implements ControllerInterface
	{
		
		/**
		 * @return array
		 */
		public function index() : array
		{
			$manager = new SerpentsManager();
			
			$serpents = $manager->findAll( ['id', 'ASC'] );
			return $this->render( "zoo/index", [
				"meta_description" => "Page d'accueil du zoo",
				"title" => "Le Zoo",
				'serpents' => $serpents
			] );
		}
		
		/**
		 * @param int|string|null $id
		 *
		 * @return array
		 */
		public function show( int|string | null $id ) : array
		{
			$manager = new SerpentsManager();
			$zoo = $manager->findOneById( $id );
			
			return $this->render( "zoo/show", [
				"meta_description" => "Page détail de " . htmlspecialchars( $zoo->get( "nom" ) ),
				"title" => htmlspecialchars( $zoo->get( "nom" ) ),
				'zoo' => $zoo
			] );
		}
		
		/**
		 * @param int|null $id
		 *
		 * @return array
		 * @throws Exception
		 */
		public function form( ?int $id ) : array
		{
			$manager = new SerpentsManager();
			$zoo = null;
			
			if( $id !== null ) {
				$zoo = $manager->findOneById( $id );
				if( !$zoo ) {
					throw new Exception( "Carte non trouvée" );
				}
			}
			
			return $this->render( "zoo/forms", [
				"meta_description" => $zoo
					? "Page de modification du Serpent " . htmlspecialchars( $zoo->get( "nom" ) )
					: "Page de création d'un nouveau Serpent",
				"title" => $zoo
					? "Édition du Serpent " . htmlspecialchars( $zoo->get( "nom" ) )
					: "Créer un nouveau Serpent",
				"zoo" => $zoo,
			] );
		}
		
		/**
		 * @param int|null $id
		 *
		 * @return void
		 * @throws Exception
		 */
		public function save( ?int $id ) : void
		{
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				$manager = new SerpentsManager();
				
				$nom = filter_input( INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$poids = filter_input( INPUT_POST, "poids", FILTER_SANITIZE_NUMBER_INT );
				$lifestamp = filter_input( INPUT_POST, "lifestamp", FILTER_SANITIZE_NUMBER_INT );
				$birthdate = filter_input( INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$birthhoure = filter_input( INPUT_POST, "birthhoure", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$race = filter_input( INPUT_POST, "race", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				$genre = filter_input( INPUT_POST, "genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS );
				
				// Validation des champs
				if( !$nom || !$poids || !$lifestamp || !$birthdate || !$birthhoure || !$race || !$genre ) {
					throw new Exception( "Données invalides. Veuillez vérifier les champs." );
				}
				
				// Validation des formats de date et heure
				$birthdateObj = DateTime::createFromFormat( 'Y-m-d', $birthdate );
				$birthhoureObj = DateTime::createFromFormat( 'H:i', $birthhoure );
				if( !$birthdateObj || !$birthhoureObj ) {
					throw new Exception( "Format de date ou d'heure invalide." );
				}
				
				// Ajout ou mise à jour
				if( $id !== null ) {
					$manager->updateOnByID( $id, $nom, $poids, $lifestamp, $birthdate, $birthhoure, $race, $genre );
				} else {
					$manager->add( [
						'nom' => $nom,
						'poids' => $poids,
						'lifestamp' => $lifestamp,
						'birthdate' => $birthdate,
						'birthhoure' => $birthhoure,
						'race' => $race,
						'genre' => $genre,
					] );
				}
				
				// Redirection en cas de succès
				$this->redirectTo( "zoo", "index" );
			} else {
				$this->redirectTo( "zoo", $id ? "form&id=$id" : "form" );
			}
		}
		
		
	}
