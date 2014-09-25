<?php


    class RegisterView {
	private $model;
	private $message;
	private $Uvalue = "";
	private $Pvalue = "";

	public function __construct(LoginModel $model) {
		$this->model = $model;
	}

    
    
    
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
		else{
			return false;
		}
	}
		
	public function HTMLPage($Message){
		$ret = "";
		
		if($this->model->registerUser()){
			$ret = "<h1>Laborationskod ej222pj</h1>
				<h2>Regi</h2>
		 		<p>$this->message</p>
		 		<p>$Message</p>";
		}
	
		return $ret;
	}
}