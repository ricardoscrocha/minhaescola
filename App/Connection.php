<?php

namespace App;

class Connection
{

	public static function getDb()
	{
		try {

			$db_connection = $_ENV['DB_CONNECTION'] ?? 'mysql';
			$db_port = $_ENV['DB_PORT'] ?? ($db_connection === 'pgsql' ? '5432' : '3306');

			$dsn = "{$db_connection}:host={$_ENV['DB_HOST']};port={$db_port};dbname={$_ENV['DB_DATABASE']}";
			
			if ($db_connection === 'mysql') {
				$dsn .= ";charset=utf8";
			}

			$conn = new \PDO(
				$dsn,
				$_ENV['DB_USER'],
				$_ENV['DB_PASSWORD']
			);

			return $conn;
			
		} catch (\PDOException $e) {
			echo ($e->getMessage());
		}
	}
}
