<?php

	require_once 'model/entity/Entity.php';

	/**
	 * Class representing a device.
	 */
	/*abstract*/ class Device extends Entity {

		const IP_REGEX = "^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$";
		const HOSTNAME_REGEX = "^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$";

		/**
		 * Given device name by it owner.
		 */
		protected $name;

		/**
		 * Router's WAN IP behind which the device is.
		 * Hostname can be IP or URI.
		 */
		protected $hostName;

		/**
		 * Router's listening port to join the device (hostname and listeningPort allow to join the router, then NAT/PAT routes to the device).
		 */
		protected $listeningPort;

		/**
		 * Constructor.
		 */
		public function __construct($info = array()) {
			$this->hydrate($info);
		}

		//Getters
		public function getName() {
			return $this->name;
		}
		public function getHostName() {
			return $this->hostName;
		}
		public function getListeningPort() {
			return $this->listeningPort;
		}

		//Setters
		protected function setName($_name) {
			if(is_string($_name))
				$this->name = $_name;
		}
		protected function setHostName($_hostname) {
			if(is_string($_hostname)) {
				if(preg_match(IP_REGEX, $_hostname) || preg_match(HOSTNAME_REGEX, $_hostname))
					$this->hostName = $_hostname;
			}
		}
		protected function setListeningPort($_listeningPort) {
			if(is_int($_listeningPort))
				$this->listeningPort = $_listeningPort;
		}

		/**
		 * @see Entity::toString().
		 */
		public function toString() {
			return ($this->name .' : ' .$this->publicIP .':' .$this->listeningPort .PHP_EOL);
		}

		/**
		 * List device functionalities.
		 */
		public /*abstract*/ function listFunctionalities() {
			return 'Cet appareil ne dispose d\'aucune fonctionnalité' .PHP_EOL;
		}
	}
