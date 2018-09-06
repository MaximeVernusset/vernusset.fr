<?php
	
	require_once 'model/entity/device/Device.php';
	
	/**
	 * Class representing a Raspberry Pi.
	 */
	abstract class RaspberryPi extends Device {
		
		/**
		 * Constructor.
		 */
		public function __construct($info) {
			parent::__construct($info);
		}
		
		/**
		 * Displays Raspberry functionalities.
		 */
		public function listFunctionalities() {
			/*TODO*/
			return 'Fonctionnalit�s RPI' .PHP_EOL;
		}
	}