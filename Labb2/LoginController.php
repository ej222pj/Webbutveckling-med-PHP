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
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();

		if($this->view->didUserPressLogin()){
			$this->model->Checklogin($username, $password);
		}

		if($this->view->didUserPressLogout()){
			
		}

		return $this->view->HTMLPage();
	}
}