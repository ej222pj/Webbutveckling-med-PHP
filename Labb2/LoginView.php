<?php

require_once("CookieStorage.php");

class LoginView {
	private $model;
	private $CookieMessage;
	private $CookieOutput;
	private $message;
	private $Uvalue = "";
	private $Pvalue = "";
	private $counter;

	public function __construct(LoginModel $model) {
		$this->model = $model;
		$this->CookieMessage = new CookieStorage();
	}

	public function RememberMe(){
		setcookie('Username', $_POST["username"], time()+60*60*24*30);
		setcookie('Password', $_POST["password"], time()+60*60*24*30);
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
			$this->counter = 0;
			return true;
		}
		else {
			return false;
		}
	}

	//Kollar om man klickat på logout knappen.
	public function didUserPressLogout(){
		if(isset($_POST['Logout'])){
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
			if($this->didUserPressLogin()){
				if($this->Checkbox()){
					$this->CookieMessage->save("Inloggning lyckades och vi kommer ihåg dig nästa gång!");
					header('Location: ' . $_SERVER['PHP_SELF']);
				}
				else if($this->Checkbox() == false){
					$this->CookieMessage->save("Inloggning lyckades!");
					header('Location: ' . $_SERVER['PHP_SELF']);
				}

			}
			else{
					$this->CookieOutput = $this->CookieMessage->load();
				}
			

			$ret = "<h2>Admin är inloggad</h2>
			 		<p>$this->CookieOutput</p>
					<form method ='post'>
						<input type=submit name='Logout' value='Logga ut'>
					</form>
					<p>$Todaytime</p>";			
		}
		
			if($this->model->loginstatus() == false) {
				$this->Uvalue = $_COOKIE['Username'];
				$this->Pvalue = $_COOKIE['Password'];


				if($this->didUserPressLogout() == false){
					if(isset($_COOKIE['Username']) && isset($_COOKIE['Password']) && $this->counter == 0){
						if($this->model->Checklogin($_COOKIE['Username'], $_COOKIE["Password"])){
							$this->counter = 1;

							$this->CookieMessage->save("Inloggning lyckades via cookies!");
							header('Location: ' . $_SERVER['PHP_SELF']);

							$ret = "<h2>Admin är inloggad</h2>
							 		<p>$this->CookieOutput</p>
									<form method ='post'>
										<input type=submit name='Logout' value='Logga ut'>
									</form>
									<p>$Todaytime</p>";
						}
					}
				}else if($this->didUserPressLogout()){
					$this->CookieMessage->save("Du är nu utloggad!");
					//header('Location: ' . $_SERVER['PHP_SELF']);
				}
				else{
					$this->CookieOutput = $this->CookieMessage->load();
				}	
					
					$ret = "<h2>Ej inloggad</h2>
						<form method='post'>
							<fieldset>
							<p>$this->message</p>
							<p>$this->CookieOutput</p>
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