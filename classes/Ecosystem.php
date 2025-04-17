<?php
	
	namespace Class;
	
	use DateMalformedStringException;
	
	class Ecosystem
	{
		/**
		 * @throws DateMalformedStringException
		 */
		public static function breed( Snake $male, Snake $female ) : ?Snake
		{
			if( $male->breed != $female->breed ) return null;
			if( $male->is_dead || $female->is_dead ) return null;
			
			$name = "baby_" . self::generateRandomName();
			$weight = rand( 100, 500 ) / 10;
			$lifespan = rand( 5, 20 );
			$birth_date = date( "Y-m-d H:i:s" );
			$gender = rand( 0, 1 ) ? 'male' : 'female';
			
			return new Snake( [
				'name' => $name,
				'weight' => $weight,
				'lifespan' => $lifespan,
				'birth_date' => $birth_date,
				'breed' => $male->breed,
				'gender' => $gender,
				'father_id' => $male->id,
				'mother_id' => $female->id,
				'is_dead' => false
			] );
		}
		
		public static function generateRandomName() : string
		{
			$names = ['Kaa', 'Sly', 'Twister', 'Zigzag', 'Fang', 'Slither', 'Venom', 'Noodle', 'Jade', 'Saphir', 'Onyx', 'Emeraude', 'Quartz', 'Obsidienne', 'Sable', 'Sahara', 'Indigo', 'Saffron', 'Azur', 'Zéphyr', 'Naga', 'Ouroboros', 'Basilic', 'Hydra', 'Draco', 'Sphinx', 'Titan', 'Jormungand'];
			return $names[ array_rand( $names ) ] . "_" . rand( 100, 999 );
		}
	}
