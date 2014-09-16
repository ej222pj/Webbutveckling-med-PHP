<?php

require_once("CookieStorage.php");

class LoginView {
	private $model;
	private $CookieMessage;
	private $message;

	public function __construct(LoginModel $model) {
		$this->model = $model;
		$this->CookieMessage = new CookieStorage();
	}

	//Hämtar ut användarnamnet
	public function getUsername(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
	}
	

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST["password"])){
			return $_POST["password"];
		}
	}

	//Kollar om man klickat på login knappen.
	public function didUserPressLogin(){
		if(isset($_POST['Login'])){
			if(($_POST["username"]) == ""){
				$this->message = "Användarnamn saknas!";
			}
			if(($_POST["password"]) == "" && ($_POST["username"]) != "") {
				$this->message = "Lösenord saknas!";
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function didUserPressLogout(){
		if(isset($_POST['Logout'])){
			return true;
		}
		else {
			return false;
		}
	}

	//Skriver ut HTMLkod efter om användaren är inloggad eller inte.
	public function HTMLPage(){
		$ret = "";

		setlocale(LC_ALL, 'swedish');
		$Todaytime = ucwords(strftime("%A,den %d %B år %Y. Klockan är [%H:%M:%S]."));	

		if($this->model->loginstatus()){
			if($this->didUserPressLogin()){
				$this->CookieMessage->save("Inloggningen lyckades!");
				header('Location: ' . $_SERVER['PHP_SELF']);
			}
			else {
				$this->message = $this->CookieMessage->load();
			}



			$ret = "<h2>Admin är inloggad</h2>
			 		$this->message
					<form method ='post'>
						<input type=submit name='Logout' value='Logga ut'>
					</form>
					<p>$Todaytime</p>";			
		}
		
			if($this->model->loginstatus() == false) {
				if($this->didUserPressLogout()){
				$this->CookieMessage->save("Du är nu utloggad!");
				header('Location: ' . $_SERVER['PHP_SELF']);
			}
			else {
				$message = $this->CookieMessage->load();
			}

				$ret = "<h2>Ej inloggad</h2>
						<form method='post'>
						<fieldset>
							$this->message
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<label>Användarnamn  :</label>
							<input type=text size=20 name='username' id='UserNameID' value>
							<label>Lösenord  :</label>
							<input type=password size=20 name='password' id='PasswordID' value>
							<label>Håll mig inloggad  :</label>
							<input type=checkbox size=20>
							<input type=submit name='Login' value='Logga in'>
						</fieldset>
					</form>
					<p>$Todaytime</p>";
			}	
		return $ret;
		
	}
}