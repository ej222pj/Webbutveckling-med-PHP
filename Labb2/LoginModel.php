<?php

class LoginModel {

	private $username = "hej";
	private $password = "hej";

	public function __construct() {

	}

	public function loginstatus(){
		if($_SESSION["loginstatus"] == 0){
			return false;
		}
		else{
			return true;
		}

	}

	//Kollar om det inmatade värdena ställer överens med rätt inlogg.
	public function Checklogin($username, $password) {

		if(isset($username) == false){
			echo "Ange användarnamn!";
		}

		if($username == $this->username && $password == $this->password){
			$_SESSION["loginstatus"] = 1;
			return true;
		}
		else {
			return false;
		}
	}
}