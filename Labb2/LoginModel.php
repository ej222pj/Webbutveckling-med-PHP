<?php
require_once ('Repository.php');

class LoginModel {

	//private $username = "Admin";
	//private $password = "Password";
	private $Repository;
	
	public function __construct() {
		$this->Repository = new Repository();
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
	//Kollar mot datorbasen om en användare finns
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
		try{
			$db = $this->Repository->connection();
	
			$sql = "INSERT INTO registernew (name, password) VALUES (?, ?)";
			$params = array($regusername, $regpassword);
	
			$query = $db->prepare($sql);
			$query->execute($params);
			return true;
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, troligtvis finns användaren tills jag fixat en check på det!");
		}
	}
	
	public function compareUsername($regusername){
		try{
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM registernew WHERE name = ?";
			$params = array($regusername);
			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			//var_dump($result);
			if($result == false){
				return true;
			}
			else{
				return false;
			}
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, kollar om användaren finns!");
		}
	}
	
	
	
	
}