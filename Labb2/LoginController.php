<?php

require_once("LoginModel.php");
require_once("LoginView.php");
//require_once("RegisterView.php");

class LoginController {
	private $view;
	//private $registerView;
	private $model;

	public function __construct() {
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
		//$this->registerView = new RegisterView($this->model);
	}

	//Kollar om användaren vill logga in
	public function doLogin() {
		$Message = "";
		
		//Inloggning via cookies
		if($this->model->loginstatus() == false){
			if($this->view->isRemembered()){
				if($this->model->CheckloginWithCookie($this->view->getCookieUsername(), $this->view->getCookiePassword())){
					$Message = "Inloggning lyckades via cookies!";
				}else{
					$this->view->removeCookie();
					$Message = "Felaktig information i cookie!";
				}
			}
		}
		
		//Registrera ny användare
		if($this->view->didUserPressRegister()){
			$Message = "Registrera fö fan!";
		
			return $this->view->registerPage($Message);
		}

		//Hämtar ut användarnamnet och lösenordet.
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();

		//Kollar om användaren vill logga in.
		//Kollar så att det är rätt användarnamn och lösenord. Om inte, skicka felmeddelande.
		if($this->view->didUserPressLogin()){
			if($username != "" && $password != ""){
				if($this->model->Checklogin($username, $password) == false){
					$Message = "Felaktigt användarnamn och/eller lösenord";
				}
				else {
					//Kollar om användaren vill hålla sig inloggd
					if($this->view->Checkbox()){
						$this->view->RememberMe();
					}else{
						$Message = "Inloggningen lyckades!";
					}
				}
			}
		}

		//Kollar om man klickat på logout knappen.
		//Anropar logout funktionen som förstör sessionen.
		if($this->view->didUserPressLogout()){
			$this->model->logout();
		}

		return $this->view->HTMLPage($Message);
	}
}