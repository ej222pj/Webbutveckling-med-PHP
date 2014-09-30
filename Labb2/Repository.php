<?php

abstract class Repository{
	
	protected $dbUsername = "root";
	protected $dbPassword = "";
	protected $dbConnstring = 'mysql:host=127.0.0.1;dbname=newmember';
	protected $dbTable = "register";
	
	protected $pdo;
	 
	public function __construct(){
		$this->pdo = self::connect(); 
	}

	protected static function connect(){
		return new \PDO(self::$dbConnstring, self::$dbUsername, self::$dbPassword);
	} 
}
