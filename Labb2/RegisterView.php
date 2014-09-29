<?php


    class RegisterView {
	private $model;
	private $message;
	private $RegUvalue = "";
	private $RegPvalue = "";
	private $RepRegPvalue = "";
	public function __construct(LoginModel $model) {
		$this->model = $model;
	}
	
	//Hämtar användarnamnet
	public function getUsername(){
		if(isset($_POST["regusername"])){
			return $_POST["regusername"];
		}
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST["regpassword"])){
			return $_POST["regpassword"];
		}
	}
	
	public function getRepPassword(){
		if(isset($_POST["repregpassword"])){
			return $_POST["repregpassword"];
		}
	}
	
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function didUserPressRegisterNew(){
		if(isset($_POST['RegisterNew'])){
			if(($_POST["regusername"]) == "" && ($_POST["regpassword"]) == ""){
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken\nLösenordet har för få tecken. Minst 6 tecken";
			}
			if(($_POST["regpassword"]) == "" && ($_POST["regusername"]) != "") {
				$this->$RegUvalue = $_POST["regusername"];
				$this->message = "Lösenord saknas!";
			}
			// if(($_POST["regpassword"]) != "" && ($_POST["regusername"]) != ""){
				// $this->$RegUvalue = $_POST["regusername"];
			// }
			return true;
		}
		else{
			return false;
		}
	}

	//Skriver ut HTMLkod efter om användaren vill registrera.
	public function registerPage($Message){
		$ret = "";

		setlocale(LC_ALL, 'swedish');
		date_default_timezone_set('Europe/Stockholm');
		$Todaytime = ucwords(strftime("%A,den %d %B år %Y. Klockan är [%H:%M:%S]."));	
		
		if($this->model->registerUser()){
			$ret = "<h1>Laborationskod ej222pj</h1>
				<form method ='post'>
						<input type=submit name='back' value='Tillbaka'>
				</form>
				<h2>Ej Inloggad, Registrerar användare</h2>
					<form method='post'>
						<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<p>$this->message</p>							
							<p>$Message</p>
							<label>Namn:</label>
							<input type=text size=20 name='regusername' id='regUserNameID' value='$this->RegUvalue'>
							<label>Lösenord:</label>
							<input type=password size=20 name='regpassword' id='regPasswordID' value='$this->RegPvalue'>
							<label>Repetera Lösenord:</label>
							<input type=password size=20 name='repregpassword' id='repregPasswordID' value='$this->RepRegPvalue'>
							<input type=submit name='RegisterNew' value='Registrera'>
						</fieldset>
					</form>
				<p>$Todaytime</p>";	
		 	return $ret;
		}
	}
}