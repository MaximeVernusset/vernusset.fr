<?php

	//Constants for the program in order to avoid "magic" strings in code
	define("PARAMETER_ACTION", "action");
	define("PARAMETER_NEXT_ACTION", "nextAction");
	define("ACTION_HOME", "home");
	define("ACTION_LOGIN", "login");
	define("ACTION_LOGOUT", "logout");
	define("AUTH_COOKIE", "Aslan_AuthToken");
	define("STAY_CONNECTED", "stayConnected");
	define("USER", "user");

	require_once 'model/manager/UserManager.php';
	require_once 'model/manager/DeviceManager.php';


	/**
	 * Main class of the program.
	 * Defines the different actions to be performed.
	 */
	class AslanController {

		/**
		 * UserManager : handles user.
		 */
		private $userManager;

		/**
		 * UserManager : handles user's devices.
		 */
		private $deviceManager;

		/**
		 * Constructor.
		 */
		public function __construct() {
			if(isset($_SESSION[USER]) && !empty($_SESSION[USER]))
				$this->userManager = new UserManager($_SESSION[USER]);
			else
				$this->userManager = new UserManager();

			$this->deviceManager = null;
		}

		/**
		 * Checks if user is connected, whether by session or authentication cookie.
		 * @return bool true if connected.
		 */
		private function isConnected() {
			if(isset($_SESSION[USER]) && !empty($_SESSION[USER])) { //User is connected
				return true;
			}
			else if(!empty($_COOKIE[AUTH_COOKIE])) { //Authentication by cookie : check if token is in database and get user info
				if($this->userManager->connectByCookie($_COOKIE[AUTH_COOKIE])) {
					$_SESSION[USER] = $this->userManager->getUser(); //User returned by cookie authentication
					return true;
				}
			}
			return false;
		}

		/**
		 * Checks in model if user credentials are valid, connects him, and redirects to the desired page (home page by default).
		 * @see handleConnectionCookie().
		 * Display again the login form if bad credentials.
		 * @param string $email user's email.
		 * @param string $password user's password.
		 * @param bool $stayConnected to set an authentication cookie if true.
		 * @param string $nextAction the action to perform after connection (home page by default).
		 */
		public function connect($email, $password, $stayConnected = false, $nextAction = ACTION_HOME) {
			if($this->userManager->connectByCredentials($email, $password)) {
				$_SESSION[USER] = $this->userManager->getUser(); //Connection in session
				$_SESSION[STAY_CONNECTED] = $stayConnected; //Useful to set the authentication cookie when next page loads
				header('Location: ./?'.PARAMETER_ACTION.'='.$nextAction);
			}
			else { //If authentication fails, display again the connection page, with a warning message.
				$warningMessage = "Informations d'identification erronées.";
				require_once 'view/connection.php';
			}
		}

		/**
		 * Checks in session if STAY_CONNECTED exists.
		 * If true : set an authentication cookie with a 32 bytes random token (and saves it in database).
		 * If false : removes cookie.
		 */
		public function handleConnectionCookie() {
			if(isset($_SESSION[STAY_CONNECTED])) {
				if($_SESSION[STAY_CONNECTED] == true) {
					$authToken = bin2hex(openssl_random_pseudo_bytes(32));
					if($this->userManager->saveAuthenticationToken($authToken))
						//setCookie(AUTH_COOKIE, $authToken, time()+60*60*24*30);
						setCookie(AUTH_COOKIE, $authToken, time()+60*60*24*30, '/', 'maxime.vernusset.ovh', 'false', 'true');
				}
				else if($_SESSION[STAY_CONNECTED] == false) {
					$this->removeCookie(AUTH_COOKIE);
				}
				unset($_SESSION[STAY_CONNECTED]);
			}
		}

		/**
		 * Set cookie expiration to 30 days ago so the user's browser removes it.
		 * Unset the cookie from $_COOKIE.
		 * @param string $cookie the cookie to be removed.
		 */
		private function removeCookie($cookie) {
			setCookie($cookie, "", time()-3600);
			unset($_COOKIE[$cookie]);
		}


		/**
		 * Displays Aslan main page if user is connected, otherwise redirects to the login page.
		 */
		public function home() {
			if($this->isConnected()) {
				$this->deviceManager = new DeviceManager($_SESSION[USER]->getEmail());
				/*TODO*/

				ob_start();
				foreach($this->deviceManager->getDevices() as $device) {
					echo '<div>';
					echo 	'<h2>'.$device->toString().'</h2>';
					echo 	$device->listFunctionalities();
					echo '</div>';
				}
				$functionalities = ob_get_flush();
				require_once 'view/home.php';
			}
			else {
				header('Location: ./?'.PARAMETER_ACTION.'='.ACTION_LOGIN);
			}
		}

		/**
		 * Displays Aslan login form if not connected yet, otherwise redirects to the desired page (home page by default).
		 * @param string $nextAction the action to perform after connection (home page by default).
		 */
		public function login($nextAction = ACTION_HOME) {
			if(!$this->isConnected())
				require_once 'view/connection.php';
			else
				header('Location: ./?'.PARAMETER_ACTION.'='.$nextAction);
		}

		/**
		* Deconnects the user : removes him from session, deletes the authentication cookie on next page load, and redirects to index.
		* @see handleConnectionCookie().
		*/
		public function logout() {
			if($this->isConnected()) {
				$this->userManager->deleteAuthenticationToken();
				unset($_SESSION[USER]);
				$_SESSION[STAY_CONNECTED] = false;
			}
			header('Location: ./');
		}


		public function test() {
			require_once 'view/test.php';
		}
	}
