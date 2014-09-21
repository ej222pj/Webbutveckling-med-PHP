<?php

class LoginModel {

	private $username = "hej";
	private $password = "hej";
	

	public function __construct() {

	}

	public function logout(){
		session_unset();
		session_destroy();
	}

	public function loginstatus(){
		if(isset($_SESSION["loginstatus"])){
			return true;
		}
		else{
			return false;
		}

	}

	//Kollar om det inmatade värdena ställer överens med rätt inlogg.
	public function Checklogin($username, $password) {

		/*
		if(isset($_COOKIE['Username']) && isset($_COOKIE['Password'])){
			if ($_COOKIE['Username'] == $this->username && $_COOKIE['Password'] == $this->md5pass){
    			return true;
			}
			else{
				return false;
			}
		}
		*/

		if($username == $this->username && $password == $this->password){
			$_SESSION["loginstatus"] = $username;
			return true;
		}
		else {
			return false;
		}
			
	}
}