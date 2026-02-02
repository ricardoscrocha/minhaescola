<?php

	//ini_set('error_reporting', 'E_STRICT');

	chdir(__DIR__);
	require_once __DIR__ . "/../vendor/autoload.php";

	if (!isset($_SESSION)) {
		session_start();
	}

	if (file_exists(__DIR__ . '/../.env')) {
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
		$dotenv->safeLoad();
	}

	$route = new \App\Route;
