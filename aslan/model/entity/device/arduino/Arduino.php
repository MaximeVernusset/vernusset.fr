<?php
	
	require_once 'model/entity/device/Device.php';
	
	/**
	 * Class representing an Arduino.
	 */
	abstract class Arduino extends Device {
		
		/**
		 * Constructor.
		 */
		public function __construct($info = array()) {
			parent::__construct($info);
		}
		
		/**
		 * Displays Arduino functionalities.
		 */
		public function listFunctionalities() {
			/*TODO*/
			return 'Fonctionnalités Arduino' .PHP_EOL;
		}
	}