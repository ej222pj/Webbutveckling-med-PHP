<?php

require_once("HTMLView.php");
require_once("LoginController.php");

//Skapar ny controller
$lc = new LoginController();
$HTMLBody = $lc->doLogin();

//Skapar ny HTMLView
$view = new HTMLView();
$view->echoHTML($HTMLBody);