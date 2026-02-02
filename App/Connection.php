<?php

namespace App;

class Connection
{

	public static function getDb()
	{
		try {

			$db_connection = $_ENV['DB_CONNECTION'] ?? getenv('DB_CONNECTION') ?: 'mysql';
			$db_host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
			$db_port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: ($db_connection === 'pgsql' ? '5432' : '3306');
			$db_name = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: '';
			$db_user = $_ENV['DB_USER'] ?? $_ENV['DB_USERNAME'] ?? getenv('DB_USER') ?: getenv('DB_USERNAME');
			$db_password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';

			$dsn = "{$db_connection}:host={$db_host};port={$db_port};dbname={$db_name}";
			
			if ($db_connection === 'mysql') {
				$dsn .= ";charset=utf8";
			}

			$conn = new \PDO(
				$dsn,
				$db_user,
				$db_password
			);

			return $conn;
			
		} catch (\PDOException $e) {
			echo ($e->getMessage());
		}
	}
}
