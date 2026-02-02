<?php

	//ini_set('error_reporting', 'E_STRICT');

	require_once "../vendor/autoload.php";

	if (file_exists(__DIR__ . '/../.env')) {
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
		$dotenv->safeLoad();
	}

	$route = new \App\Route;
	
?>
