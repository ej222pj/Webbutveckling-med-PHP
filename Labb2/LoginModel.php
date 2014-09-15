<?php

class LoginModel {

	private $username = "hej";
	private $password = "hej";

	public function __construct() {

	}

	public function logout(){
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

		if(isset($username) == false){
			echo "Ange användarnamn!";
		}

		if($username == $this->username && $password == $this->password){
			$_SESSION["loginstatus"] = $username;
			return true;
		}
		else {
			return false;
		}
	}
}