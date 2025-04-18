<?php
	
	namespace App\Class\Entities;
	
	class GenealogyEntry
	{
		private(set) ?int $level = null {
			get {
				return $this->level;
			}
		}
		private(set) ?Snake $snake = null {
			get {
				return $this->snake;
			}
		}
		
		public function __construct( int $level, Snake $snake )
		{
			$this->level = $level;
			$this->snake = $snake;
		}
	}
