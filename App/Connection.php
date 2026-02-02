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
			$db_ssl_mode = strtolower((string) ($_ENV['DB_SSL_MODE'] ?? getenv('DB_SSL_MODE') ?: 'require'));
			$db_ssl_ca = $_ENV['DB_SSL_CA'] ?? getenv('DB_SSL_CA') ?: '';

			$dsn = "{$db_connection}:host={$db_host};port={$db_port};dbname={$db_name}";
			$options = [];
			
			if ($db_connection === 'mysql') {
				$dsn .= ";charset=utf8";

				if ($db_ssl_mode !== 'disable') {
					$caPath = $db_ssl_ca;

					if ($caPath === '') {
						$defaultCaPaths = [
							'/etc/ssl/certs/ca-certificates.crt',
							'/etc/ssl/certs/ca-bundle.crt',
							'/etc/ssl/cert.pem',
							'/etc/pki/tls/certs/ca-bundle.crt'
						];

						foreach ($defaultCaPaths as $path) {
							if (is_readable($path)) {
								$caPath = $path;
								break;
							}
						}
					}

					if ($caPath !== '') {
						if (defined('\PDO::MYSQL_ATTR_SSL_CA')) {
							$options[\PDO::MYSQL_ATTR_SSL_CA] = $caPath;
						}
					}

					// Force encrypted transport even when CA bundle path is unavailable.
					if (defined('\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
						$options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = $db_ssl_mode === 'verify';
					}
				}
			}

			$conn = new \PDO(
				$dsn,
				$db_user,
				$db_password,
				$options
			);

			return $conn;
			
		} catch (\PDOException $e) {
			error_log('DB connection failed: ' . $e->getMessage());
			return null;
		}
	}
}
