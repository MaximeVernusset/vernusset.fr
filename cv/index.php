<?php

	require_once 'controller/cvController.php';
	$cv = new cvController();
	
	if(isset($_GET[ACTION]) && !is_null($_GET[ACTION])) {
		switch($_GET[ACTION]) {
			case ACTION_EXPORT: $cv->displayExport();
				break;
			default: $cv->display();
				break;
		}
	}
	else
		$cv->display();