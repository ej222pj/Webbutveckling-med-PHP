<?php
require_once ('Repository.php');

class LoginModel {

	private $username = "Admin";
	private $password = "Password";
	
	// public $user_name = "root";
	// public $pass = "";
	// public $database = "newmember";
	// public $server = "mysql:host=127.0.0.1;dbname=newmember";
	
	

	public function __construct() {

	}

	//Förstör sessionen.
	public function logout(){
		session_unset();
		session_destroy();
	}
	
	public function registerUser(){
		//$_SESSION["registerstatus"] = true;
			
		return true;
	}
	
	public function CheckRegisterNew($regusername){
		if($this->username !== $regusername){
			return true;
		}
		else{
			return false;
		}
	}

	//Kollar om sessionen är satt och retunera ture om användaren är inloggad
	//Kollar även om användaren försöker att logga in med fake session.
	public function loginstatus(){
		if(isset($_SESSION["browserstatus"]) && $_SESSION["browserstatus"] == $_SERVER['HTTP_USER_AGENT']){
			if(isset($_SESSION["loginstatus"])){
				return true;
			}
		}
		return false;

	}

	//Kollar så att cookie uppgifterna stämmer
	public function CheckloginWithCookie($username, $password){
		$CookieTime = file_get_contents('CookieTime.txt');

		if ($username == $this->username && $password == md5($this->password) && $CookieTime > time()){
			$_SESSION["loginstatus"] = $username;
			$_SESSION["browserstatus"] = $_SERVER['HTTP_USER_AGENT'];
			return true;
		}
		else{
			return false;
		}
	}
	

	//Kollar om det inmatade värdena ställer överens med rätt inlogg.
	public function Checklogin($username, $password){
		if($username == $this->username && $password == $this->password){
			$_SESSION["loginstatus"] = $username;
			$_SESSION["browserstatus"] = $_SERVER['HTTP_USER_AGENT'];
			return true;
		}
		else {
			return false;
		}
	}
	
	public function addUser($regusername, $regpassword){
		//try{
			//$db = $this->connection();
			$con=mysqli_connect("127.0.0.1","root","","newmember");
			// Check connection
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			mysqli_query($con,"INSERT INTO register (name, password)
			VALUES ('$regusername', '$regpassword')");
			
			mysqli_close($con);
			return true;
						

	}
}