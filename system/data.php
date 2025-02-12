<?php
	/* *******************************************************************************************************
	/* data.php regelt die DB-Verbindung und fast den gesammten Datenverkehr der Site.
	/* So ist die gesammte Datenorganisation an einem Ort, was den Verwaltungsaufwand erheblich verringert.
	/*
	/* *******************************************************************************************************/

	/* *******************************************************************************************************
	/* get_db_connection()
	/*
	/* liefert als Rückgabewert die Datenbankverbindung
	/* hier werden für die gesammte Site die DB-Verbindungsparameter angegeben.
	/* 	"SET NAMES 'utf8'"  :	Sorgt dafür, dass alle Zeichen als UTF8 übertragen und gespeichert werden.
	/*							http://www.lightseeker.de/wunderwaffe-set-names-set-character-set/
	/* *******************************************************************************************************/
	function get_db_connection()
	{
    $db = mysqli_connect('localhost', 'root', '', 'bundesraten');
    if (mysqli_connect_error()) {
        die('Verbindungsfehler (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    mysqli_query($db, "SET NAMES 'utf8'");
		return $db;
	}

	/* *******************************************************************************************************
	/* get_result($sql)
	/*
	/* Führt die SQL-Anweisung $sql aus, liefert das Ergebnis zurück und schliesst die DB-Verbindung
	/* Alle Weiteren Funktionen rufen get_result() auf.
	/* *******************************************************************************************************/
	function get_result($sql)
	{
		$db = get_db_connection();
    // echo $sql ."<br>";
		$result = mysqli_query($db, $sql);
		mysqli_close($db);
		return $result;
	}

	/* *******************************************************************************************************
	/* Login
	/* *******************************************************************************************************/
	function login($username , $password){
		$sql = "SELECT * FROM user WHERE email='$username' AND password='$password';";
		return get_result($sql);
	}

	/* *******************************************************************************************************
	/* Registrierung
	/* *******************************************************************************************************/

	function register($password, $email, $firstname, $lastname, $year, $class){
    $sql = "INSERT INTO user (password, email, firstname, lastname, year, class) VALUES ('$password', '$email', '$firstname', '$lastname', '$year', '$class');";
		return get_result($sql);
	}

	function does_email_exist($email){
		$sql = "SELECT * FROM user WHERE email='$email';";
		$result = get_result($sql);
		if(mysqli_num_rows($result) > 0){
			return true;
		}
		return false;
	}

	/* *******************************************************************************************************
	/* Tippen
	/* *******************************************************************************************************/
	function tipp($user_id, $tipp1, $tipp1stimmen, $tipp2, $tipp2stimmen, $tipp3, $tipp3stimmen, $tipp4, $tipp4stimmen, $tipp5, $tipp5stimmen, $tipp6, $tipp6stimmen, $tipp7, $tipp7stimmen){
		$sql = "INSERT INTO tipps (user_id, tipp1, tipp1stimmen, tipp2, tipp2stimmen, tipp3, tipp3stimmen, tipp4, tipp4stimmen, tipp5, tipp5stimmen, tipp6, tipp6stimmen, tipp7, tipp7stimmen) VALUES ('$user_id', '$tipp1', '$tipp1stimmen', '$tipp2', '$tipp2stimmen', '$tipp3', '$tipp3stimmen', '$tipp4', '$tipp4stimmen', '$tipp5', '$tipp5stimmen', '$tipp6', '$tipp6stimmen', '$tipp7', '$tipp7stimmen');";
		return get_result($sql);
	}

	function get_tipp($user_id){
		$sql = "SELECT * FROM tipps WHERE user_id = '$user_id';";
		return get_result($sql);
	}

	function does_tipp_exist($user_id) {
		$sql = "SELECT * FROM tipps WHERE user_id = '$user_id';";
		$result = get_result($sql);
		if(mysqli_num_rows($result) > 0){
			return true;
		}
		return false;	}

	/* *******************************************************************************************************
	/* Index
	/* *******************************************************************************************************/

	function get_user_by_id($id){
		$sql = "SELECT * FROM user WHERE id=$id;";
		return get_result($sql);
	}
