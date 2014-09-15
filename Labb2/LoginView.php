<?php

class LoginView {
	private $model;

	public function __construct(LoginModel $model) {
		$this->model = $model;
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
			$ret = "<h2>Admin är inloggad</h2>
					<p>Inloggning lyckades</p>
					<form method ='post'>
						<input type=submit name='Logout' value='Logga ut'>
					</form>
					<p>$Todaytime</p>";
		}
			else {
				$ret = "<h2>Ej inloggad</h2>
						<form method='post'>
						<fieldset>
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

			if($this->didUserPressLogout()){
				header('Location: ' . $_SERVER['PHP_SELF']);
			}
		return $ret;
		
	}
}