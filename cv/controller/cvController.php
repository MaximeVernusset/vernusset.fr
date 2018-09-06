<?php

	define('ACTION', 'action');
	define('ACTION_EXPORT', 'export');
	
	class cvController {		
		
		public function display() {
			require 'view/cv.html';
		}
	
		public function displayExport() {
			require 'view/cvExport.html';
		}
	}