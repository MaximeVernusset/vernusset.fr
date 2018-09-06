<?php

	require_once 'controller/AslanController.php';

	session_start();
	//session_destroy();

	$aslan = new AslanController();
	$aslan->handleConnectionCookie(); //Create or delete auth cookie if needed

	//Router
	try {
		if(isset($_GET[PARAMETER_ACTION])) {
			switch($_GET[PARAMETER_ACTION]) {
				case ACTION_LOGIN:
					isset($_GET[PARAMETER_NEXT_ACTION]) ? $aslan->login($_GET[PARAMETER_NEXT_ACTION]) : $aslan->login();
					break;
				case ACTION_LOGOUT:
					$aslan->logout();
					break;
				case ACTION_HOME:
					$aslan->home();
					break;
				/*case 'test':
					$aslan->test();
					break;*/
				default: $aslan->home();
					break;
			}
		}
		else if(isset($_POST['connect']) && isset($_POST['email']) && isset($_POST['password'])) { //Connection
			$stayConnected = isset($_POST[STAY_CONNECTED]);
			if(isset($_POST[PARAMETER_NEXT_ACTION]))
				$aslan->connect($_POST['email'], $_POST['password'], $stayConnected, $_POST[PARAMETER_NEXT_ACTION]);
			else
				$aslan->connect($_POST['email'], $_POST['password'], $stayConnected);
		}
		else
			$aslan->home();
	}
	catch(Exception $e) {
		echo 'Erreur : ' . $e->getMessage();
	}