<?php
	
	namespace App\Class\Entities;
	
	use DateMalformedStringException;
	use DateTime;
	
	class Snake
	{
		private(set) ?int $id = null {
			get {
				return $this->id;
			}
		}
		private(set) ?bool $is_dead = false {
			get {
				return $this->is_dead;
			}
		}
		private(set) ?string $gender = null {
			get {
				return $this->gender;
			}
		}
		private(set) ?string $breed = null {
			get {
				return $this->breed;
			}
		}
		private(set) string | null | DateTime $birth_date = null {
			get {
				return $this->birth_date;
			}
		}
		private(set) ?float $lifespan = null {
			get {
				return $this->lifespan;
			}
		}
		private(set) ?string $name = null {
			get {
				return $this->name;
			}
		}
		private(set) ?float $weight = null {
			get {
				return $this->weight;
			}
		}
		private(set) mixed $mother_id = null {
			get {
				return $this->mother_id;
			}
		}
		private(set) mixed $father_id = null {
			get {
				return $this->father_id;
			}
		}
		
		/**
		 * @param int|null $id
		 *
		 * @return Snake
		 */
		public function setId( ?int $id ) : self
		{
			$this->id = $id;
			return $this;
		}
		
		/**
		 * @param DateTime|string|null $birth_date
		 *
		 * @return Snake
		 */
		public function setBirthDate( DateTime | string | null $birth_date ) : self
		{
			$this->birth_date = $birth_date;
			return $this;
		}
		
		/**
		 * @param string|null $breed
		 *
		 * @return Snake
		 */
		public function setBreed( ?string $breed ) : self
		{
			$this->breed = $breed;
			return $this;
		}
		
		/**
		 * @param mixed $father_id
		 *
		 * @return Snake
		 */
		public function setFatherId( mixed $father_id ) : self
		{
			$this->father_id = $father_id;
			return $this;
		}
		
		/**
		 * @param string|null $gender
		 *
		 * @return Snake
		 */
		public function setGender( ?string $gender ) : self
		{
			$this->gender = $gender;
			return $this;
		}
		
		/**
		 * @param bool|null $is_dead
		 *
		 * @return Snake
		 * */
		public function setIsDead( ?bool $is_dead ) : self
		{
			$this->is_dead = $is_dead;
			return $this;
		}
		
		/**
		 * @param float|null $lifespan
		 *
		 * @return Snake
		 */
		public function setLifespan( ?float $lifespan ) : self
		{
			$this->lifespan = $lifespan;
			return $this;
		}
		
		/**
		 * @param mixed $mother_id
		 *
		 * @return Snake
		 */
		public function setMotherId( mixed $mother_id ) : self
		{
			$this->mother_id = $mother_id;
			return $this;
		}
		
		/**
		 * @param string|null $name
		 *
		 * @return Snake
		 */
		public function setName( ?string $name ) : self
		{
			$this->name = $name;
			return $this;
		}
		
		/**
		 * @param float|null $weight
		 *
		 * @return Snake
		 */
		public function setWeight( ?float $weight ) : self
		{
			$this->weight = $weight;
			return $this;
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function __construct( $data )
		{
			$this->id = $data['id'] ?? null;
			$this->name = $data['name'] ?? '';
			$this->weight = $data['weight'] ?? 0;
			$this->lifespan = $data['lifespan'] ?? 0;
			$this->birth_date = $data['birth_date'] ?? '';
			$this->breed = $data['breed'] ?? '';
			$this->gender = $data['gender'] ?? '';
			$this->father_id = $data['father_id'] ?? null;
			$this->mother_id = $data['mother_id'] ?? null;
			$this->is_dead = $data['is_dead'] ?? false;
			
			$this->updateDeathStatus();
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function age() : int
		{
			return date_diff( new DateTime( $this->birth_date ), new DateTime() )->y;
		}
		
		/**
		 * @throws DateMalformedStringException
		 */
		public function updateDeathStatus() : void
		{
			if( !$this->is_dead && $this->age() >= $this->lifespan ) {
				$this->is_dead = true;
			}
		}
	}
