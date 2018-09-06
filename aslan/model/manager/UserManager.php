<?php
	
	require_once 'model/manager/Manager.php';
	require_once 'model/entity/user/User.php';
	
	/**
	 * Handles user interactions with database.
	 */
	class UserManager extends Manager{
		
		/**
		 * Connected user.
		 */
		private $user;
		
		/**
		 * Constructor.
		 * If 1 argument : sets user to this argument, otherwise null.
		 */
		public function __construct() {
			parent::__construct();
			
			if(func_num_args() == 1)
				$this->user = func_get_args()[0];
			else
				$this->user = null;
		}		
		
		/**
		 * Getter.
		 * @return User connected user.
		 */
		public function getUser() {
			return $this->user;
		}
		
		/**
		 * Connects the user using the provided credentials.
		 * Check if in database and get user info.
		 * @param string $email user email.
		 * @param string $password user password.
		 * @return bool the result of connection.
		 */
		public function connectByCredentials($email, $password) {
			$password = hash(HASH_ALGORITHM, $password);
			$query = $this->dbConnection->prepare("SELECT email, name, surname FROM Users WHERE email=? AND password=?");
			$query->execute(array($email, $password));
			
			if($userInfo = $query->fetch(PDO::FETCH_ASSOC)) {
				$this->user = new User($userInfo);
				return true;
			}
			return false;
		}
		
		/**
		 * Connects the user using the provided authentication token.
		 * @param string $token authentication token.
		 * @return bool the result of connection.
		 */
		public function connectByCookie($authToken) {
			$authToken = hash(HASH_ALGORITHM, $authToken);
			$query = $this->dbConnection->prepare('SELECT email, name, surname FROM Users WHERE authToken=?');
			$query->execute(array($authToken));
			if($userInfo = $query->fetch(PDO::FETCH_ASSOC)) {
				$this->user = new User($userInfo);
				return true;
			}
			return false;
		}
		
		/**
		 * Update the authentication token in the database.
		 * @param string $token new authentication token.
		 * @return bool true if one tuple was affected, false otherwise.
		 */
		public function saveAuthenticationToken($authToken) {
			$authToken = hash(HASH_ALGORITHM, $authToken);
			$query = $this->dbConnection->prepare('UPDATE Users SET authToken=? WHERE email=?');
			$nbUpdatedRows = $query->execute(array($authToken, $this->user->getEmail()));
			return $nbUpdatedRows == 1;
		}
		
		/**
		 * Delete the authentication token in the database.
		 * @return bool true if one tuple was affected, false otherwise.
		 */
		public function deleteAuthenticationToken() {
			$query = $this->dbConnection->prepare('UPDATE Users SET authToken=NULL WHERE email=?');
			$nbUpdatedRows = $query->execute(array($this->user->getEmail()));
			return $nbUpdatedRows == 1;
		}
	}