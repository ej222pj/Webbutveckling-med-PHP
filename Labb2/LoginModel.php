<?php

class LoginModel {

	private $username = "Admin";
	private $password = "Password";
	

	public function __construct() {

	}

	//Förstör sessionen.
	public function logout(){
		session_unset();
		session_destroy();
	}
	
	public function registerUser(){
		
		return true;
		
		return false;
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
}