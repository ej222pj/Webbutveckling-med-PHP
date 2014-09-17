<?php

class CookieStorage {
	private $cookieName = "CookieStorage";

	public function save($string) {
		setcookie($this->cookieName, $string, -1);
	}

	public function load() {
		if (isset($_COOKIE[$this->cookieName])){
			$ret = $_COOKIE[$this->cookieName];
		}
		else{
			$ret = "";
		}
		
		//setcookie($this->cookieName, "", time() -1);

		return $ret;
	}
}