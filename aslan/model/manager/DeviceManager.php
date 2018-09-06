<?php

	require_once 'model/manager/Manager.php';

	spl_autoload_register(function($className) {
		include 'model/entity/device/raspberryPi/models/'.$className.'.php';
	});
	spl_autoload_register(function($className) {
		include 'model/entity/device/arduino/models/'.$className.'.php';
	});

	/**
	 * Handles user's devices.
	 */
	class DeviceManager extends Manager{

		//Device types constants
		const DEVICE_TYPE_RPI_B = "RPI_B";

		/**
		 * List of devices owned by the connected user.
		 */
		private $devices;

		/**
		 * Constructor.
		 * If 1 argument : sets user to this argument, otherwise null.
		 */
		public function __construct($userEmail) {
			parent::__construct();
			$this->devices = $this->getUserDevicesFromDatabase($userEmail);
		}

		/**
		 * Getter.
		 */
		public function getDevices() {
			return $this->devices;
		}

		/**
		 * Loads all user's devices info and instanciates the corresponding class depending on device type.
		 * @return array list of user's devices.
		 */
		public function getUserDevicesFromDatabase($userEmail) {
			$deviceList = array();
			$query = $this->dbConnection->prepare("SELECT type, name, hostname, listeningPort FROM Devices WHERE user=?");
			$query->execute(array($userEmail));
			while($deviceInfo = $query->fetch(PDO::FETCH_ASSOC)) {
				switch($deviceInfo['type']) {
					case DEVICE_TYPE_RPI_B: $device = new RaspberryPiModelB($deviceInfo);
						break;
					default: $device = new Device($deviceInfo);
						break;
				}
				array_push($deviceList, $device);
			}
			return $deviceList;
		}
	}
