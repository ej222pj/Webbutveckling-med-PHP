<?php

//HTML basklass
class HTMLView {
	public function echoHTML($body) {
		echo "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset=UTF-8>
					<title>Tims login</title>
				</head>
				<body>
					$body
				</body>
				</html>
		";
	}
}