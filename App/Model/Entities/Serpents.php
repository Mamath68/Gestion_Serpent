<?php
	
	namespace App\Model\Entities;
	
	use App\config\Entity;
	use DateMalformedStringException;
	use DateTime;
	use DateTimeZone;
	
	final class Serpents extends Entity
	{
		
		private int $id;
		private string $nom;
		private int $poids;
		private int $lifestamp;
		private DateTime | string $birthdate;
		private DateTime | string $birthhoure;
		private string $race;
		private string $genre; // Propriété ENUM
		
		
		public function __construct( $data )
		{
			$this->hydrate( $data );
		}
		
		public function get( $params ) : mixed
		{
			return $this->$params;
		}
		
		public function setId( int $id ) : void
		{
			$this->id = $id;
		}
		
		public function setNom( string $nom ) : void
		{
			$this->nom = $nom;
		}
		
		public function setPoids( int $poids ) : void
		{
			$this->poids = $poids;
		}
		
		public function setLifestamp( int $lifestamp ) : void
		{
			$this->lifestamp = $lifestamp;
		}
		
		public function getBirthDate() : DateTime | string
		{
			return $this->birthdate->format( 'd-m-Y' );
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function setBirthDate( DateTime | DateTimeZone | string | null $birthdate ) : void
		{
			$this->birthdate = new DateTime( $birthdate );
		}
		
		public function setRace( string $race ) : void
		{
			$this->race = $race;
		}
		
		public function setGenre( string $genre ) : void
		{
			$this->genre = $genre;
		}
		
		public function getBirthHoure() : DateTime | string
		{
			return $this->birthhoure->format( 'H:i' );
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function setBirthHoure( DateTime | DateTimeZone | string | null $birthhoure ) : void
		{
			$this->birthhoure = new DateTime( $birthhoure );
		}
		
		public function __toString()
		{
			return $this->get( "id" ) . ' ' . $this->get( "nom" ) . ' ' . $this->get( "poids" ) . ' ' . $this->get( "lifestamp" ) . ' ' . $this->getBirthDate() . ' ' . $this->getBirthHoure() . ' ' . $this->get( "race" ) . ' ' . $this->get( "genre" );
		}
		
	}
