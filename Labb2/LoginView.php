<?php

class LoginView {
	private $model;
	private $message;
	private $Uvalue = "";
	private $Pvalue = "";

	public function __construct(LoginModel $model) {
		$this->model = $model;
	}

	public function RememberMe(){
		setcookie('Username', $_POST["username"], time()+60*60*24*30);
		setcookie('Password', md5($_POST["password"]), time()+60*60*24*30);
		$this->message = "Inloggning lyckades och vi kommer ihåg dig nästa gång!";
	}

	public function isRemembered(){
		if(isset($_COOKIE['Username']) && isset($_COOKIE['Password'])){
			return true;
		}
		else{
			return false;
		}
	}

	public function getCookieUsername(){
		return $_COOKIE['Username'];
	}

	public function getCookiePassword(){
		return $_COOKIE['Password'];
	}

	public function Checkbox(){
		if(isset($_POST['checkbox'])){
			return true;
		}
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
	//Kollar om användaren skickar med input och skriver ut felmeddelanden.
	public function didUserPressLogin(){
		if(isset($_POST['Login'])){
			if(($_POST["username"]) == ""){
				$this->message = "Användarnamn saknas!";
			}
			if(($_POST["password"]) == "" && ($_POST["username"]) != "") {
				$this->Uvalue = $_POST["username"];
				$this->message = "Lösenord saknas!";
			}
			if(($_POST["password"]) != "" && ($_POST["username"]) != ""){
				$this->Uvalue = $_POST["username"];
			}
			return true;
		}
		else {
			return false;
		}
	}

	//Kollar om man klickat på logout knappen.
	public function didUserPressLogout(){
		if(isset($_POST['Logout'])){
			$this->message = "Du är nu utloggad!";
			setcookie ('Username', "", time() - 3600);
			setcookie ('Password', "", time() - 3600);
			return true;
		}
		else {
			return false;
		}
	}

	//Skriver ut HTMLkod efter om användaren är inloggad eller inte.
	public function HTMLPage($wrongInputMessage){
		$ret = "";

		setlocale(LC_ALL, 'swedish');
		$Todaytime = ucwords(strftime("%A,den %d %B år %Y. Klockan är [%H:%M:%S]."));	

		if($this->model->loginstatus()){
			$ret = "<h2>Admin är inloggad</h2>
			 		<p>$this->message</p>
			 		<p>$wrongInputMessage</p>
					<form method ='post'>
						<input type=submit name='Logout' value='Logga ut'>
					</form>
					<p>$Todaytime</p>";
		}
		
			if($this->model->loginstatus() == false) {
					$ret = "<h2>Ej inloggad</h2>
						<form method='post'>
							<fieldset>
							<p>$this->message</p>							
							<p>$wrongInputMessage</p>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<label>Användarnamn  :</label>
							<input type=text size=20 name='username' id='UserNameID' value='$this->Uvalue'>
							<label>Lösenord  :</label>
							<input type=password size=20 name='password' id='PasswordID' value='$this->Pvalue'>
							<label>Håll mig inloggad  :</label>
							<input type=checkbox size=20 name='checkbox'>
							<input type=submit name='Login' value='Logga in'>
							</fieldset>
						</form>
						<p>$Todaytime</p>";	
			}	
		return $ret;
		
	}
}