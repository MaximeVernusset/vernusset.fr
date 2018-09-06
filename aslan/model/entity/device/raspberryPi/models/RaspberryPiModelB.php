<?php
	
	require_once 'model/entity/device/raspberryPi/RaspberryPi.php';
	
	/**
	 * Class representing a Raspberry Pi model B.
	 */
	class RaspberryPiModelB extends RaspberryPi {
		
		/**
		 * Constructor.
		 */
		public function __construct($info = array()) {
			parent::__construct($info);
		}
		
		/**
		 * Displays Raspberry functionalities.
		 */
		public function listFunctionalities() {
			/*TODO*/
			$f = parent::listFunctionalities();
			return  $f .'Fonctionnalités RPI propres au Modèle B' .PHP_EOL;
		}
	}