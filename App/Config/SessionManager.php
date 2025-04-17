<?php
	
	namespace App\Config;
	
	class SessionManager
	{
		
		public static function start() : void
		{
			if( session_status() === PHP_SESSION_NONE ) {
				session_start();
			}
		}
	}
