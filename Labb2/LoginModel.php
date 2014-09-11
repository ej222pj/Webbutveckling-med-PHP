<?php

class LoginModel {

	public function __construct() {

	}

	//Kollar om det inmatade värdena ställer överens med rätt inlogg.
	public function Checklogin($username, $password) {

		if($username == "hej" && $password == "hej"){
			return true;
		}
		else {
			return false;
		}
	}
}