<?php

	require_once 'model/entity/Entity.php';

	/**
	 * Class encapsulating user info.
	 */
	class User extends Entity {

		/**
		 * User email.
		 */
		private $email;
		/**
		 * User name.
		 */
		private $name;
		/**
		 * User surname.
		 */
		private $surname;

		/**
		 * Constructor.
		 * @param array $info user info to store in class attributes.
		 */
		public function __construct($info = array()) {
			$this->hydrate($info);
		}

		//Getters
		public function getEmail() {
			return $this->email;
		}
		public function getName() {
			return $this->name;
		}
		public function getSurname() {
			return $this->surname;
		}

		//Setters
		protected function setEmail($_email) {
			if(is_string($_email))
				$this->email = $_email;
		}
		public function setName($_name) {
			if(is_string($_name))
				$this->name = $_name;
		}
		public function setSurname($_surname) {
			if(is_string($_surname))
				$this->surname = $_surname;
		}

		/**
		 * @see Entity::toString().
		 */
		public function toString() {
			return ($this->email .PHP_EOL .$this->surname .PHP_EOL .$this->name .PHP_EOL);
		}
	}
