<?php
	
	//Database info
	define("DB_DSN", "mysql");
	define("DB_HOST", "localhost");
	define("DB_SCHEMA", "aslan");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "admin");
	//Hash algorithm used to encrypt password
	define("HASH_ALGORITHM", "sha256");
	
	
	/**
	 * Handles the database connection.
	 */
	abstract class Manager {
		
		/**
		 * Connection to database.
		 */
		protected $dbConnection;
		
		/**
		 * Constructor.
		 * Initiates connection to database.
		 */
		public function __construct() {
			$this->dbConnection = new \PDO(DB_DSN.':host='.DB_HOST.';dbname='.DB_SCHEMA.';charset=utf8', DB_USERNAME, DB_PASSWORD, 
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
	}