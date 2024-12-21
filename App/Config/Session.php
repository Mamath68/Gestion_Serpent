<?php
	
	namespace App\Config;
	
	use Exception;
	
	class Session
	{
		/**
		 * @return void
		 * @throws Exception
		 */
		public static function start() : void
		{
			if( session_status() == PHP_SESSION_NONE ) {
				session_start();
			} else if( session_status() == PHP_SESSION_DISABLED ) {
				throw new Exception( "Les sessions sont désactivées sur ce serveur." );
			}
		}
		
		/**
		 * @var string[]
		 */
		private static array $validCategories = ['error', 'success'];
		
		/**
		 * @param string $categ
		 * @param string $msg
		 *
		 * @return void
		 */
		public static function addFlash( string $categ, string $msg ) : void
		{
			if( in_array( $categ, self::$validCategories ) ) {
				// Optionnel : Échapper les messages pour éviter les injections XSS
				$_SESSION[ $categ ] = htmlspecialchars( $msg, ENT_QUOTES, 'UTF-8' );
			}
		}
		
		/**
		 * @param string $categ
		 *
		 * @return string
		 */
		
		public static function getFlash( string $categ ) : string
		{
			if( in_array( $categ, self::$validCategories ) && isset( $_SESSION->$categ ) ) {
				$msg = $_SESSION->$categ;
				unset( $_SESSION->$categ );
				return $msg;
			}
			return "";
		}
	}
