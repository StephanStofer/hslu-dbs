<?php
	ini_set('display_errors', 0);
	//error_reporting(-1);
	
	function Connection(){
		$server='dbs-f20-tbstofer.el.eee.intern:3306';
		$user='php_user';
		$pass='lassie-bunch-mentor';
		$db='dbs';	   	

		$mysqli = new mysqli($server, $user, $pass, $db);
		if ($mysqli->connect_errno) {
			die("Verbindung fehlgeschlagen: " . $mysqli->connect_error . '<br><br><p style="color:red"><b>Sind Sie im VPN angemeltet? ;-)</b></p>');
		}
		return $mysqli;
	}
?>