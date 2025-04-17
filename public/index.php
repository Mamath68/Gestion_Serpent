<?php
	
	use App\Config\SessionManager;
	use App\Config\Router;
	
	const STYLE_DIR = "../assets/css";
	const SCRIPT_DIR = "../assets/js";
	const VIEW_DIR = __DIR__ . "/../App/Views";
	
	require_once __DIR__ . '/../vendor/autoload.php';
	SessionManager::start();
	
	$router = new Router();
	$router->routes();
	
