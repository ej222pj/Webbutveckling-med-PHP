<?php

require_once("LoginModel.php");
require_once("LoginView.php");

class LoginController {
	private $view;
	private $model;

	public function __construct() {
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}

	//Kollar om användaren vill logga in
	public function doLogin() {

		//Hämtar ut användarnamnet och lösenordet.
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$wrongInputMessage = "";

		//Kollar om användaren vill logga in.
		//Kollar så att det är rätt användarnamn och lösenord. Om inte, skicka felmeddelande.
		if($this->view->didUserPressLogin()){
			if($username != "" && $password != ""){
				if($this->model->Checklogin($username, $password) == false){
					$wrongInputMessage = "Felaktigt användarnamn och/eller lösenord";
				}
			}
			
			
		}

		//Kollar om man klickat på logout knappen.
		//Anropar logout funktionen som förstör sessionen.
		if($this->view->didUserPressLogout()){
			$this->model->logout();
		}

		return $this->view->HTMLPage($wrongInputMessage);
	}
}