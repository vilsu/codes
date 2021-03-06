<?php

/**
 * @brief   Ota sisaankirjautumiskentat, email ja salasana
 * @file    receive_login_form.php
 */

ob_start();

session_save_path("/tmp/");
session_start();

// Tata lomaketta suoritetaan vain, kun kayttaa *lomake_login.php*

/** 
 * @brief   Tarkasta salasana
 * @param $password string
 * @return boolean
 */
function validate_password ( $password )
{
	if ( mb_strlen ( $password ) < 6)
		return false;
	else
		return true;
}


/** 
 * @brief   Tarkasta email
 * @param $email string
 * @return boolean
 */
function validate_email ( $email ) 
{
	if ( filter_var ( $email, FILTER_VALIDATE_EMAIL ) ) 
	{
		// though the filter
		return true;
	}
	else 
	{
		echo ("Wrong email address.");
		return false; 
	}
}

/** Tarkasta sisaankirjautumislomake
 * @param $email string
 * @param $password string
 * @return boolean
 */
function validate ( $email, $password )
{
	if (  (validate_email ( $email ) )
			&& (validate_password ( $password ) ) )
		return true;
	else
		return false;
}


/** Ota kayttajatunniste
 * @param $email string
 * @return integer
 */
function get_user_id ( $email ) 
{
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");
	// grap the user_id
	$result = pg_query_params( $dbconn,
			'SELECT user_id
			FROM users
			WHERE email = $1',
			array( $email )  
			);
	/**
	 * $user_id integer
	 */
	while ( $row = pg_fetch_array( $result ) ) {
		$user_id = (int) $row['user_id'];
	}
	return $user_id;
}

/** Ota sisaankirjautujan nimi
 * @param $email string
 * @return string
 */
function get_username ( $email ) 
{
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");
	// grap the user_id
	/*
	 * $email string
	 */
	$result = pg_query_params( $dbconn,
			'SELECT username
			FROM users
			WHERE email = $1',
			array( $email )  
			);
	/**
	 * $username string
	 */
	while ( $row = pg_fetch_array( $result ) ) {
		$username = $row['username'];
	}
	return $username;
}


/** Ota kysymystunniste
 * @return integer 
 */
function get_question_id_ref ( ) {
	if ( empty ( $_GET['question_id'] ) )
		return $_GET['question_id'];
	else if ( !empty ( $_SERVER['HTTP_REFERER'] ) ) 
	{

		/**
		 *  string $pattern
		 *  string $subject
		 *  string $query
		 *  integer $question_id
		 */
		// To redirect the user back to the question where he logged in
		$pattern = '/question_id=([^#&]*)/';
		$subject = $_SERVER['HTTP_REFERER'];
		// extract query from URL
		$query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
		parse_str($query, $params);
		$question_id = explode ( '=', $query );
		$question_id = $question_id[0];

		return $question_id;
	}
	else 
		return false;
}


/** 
 * Ohjaa halutulle sivulle
 */
function direct_right ()
{
	header("Location: /pgCodesS/index.php?"
			. "successful_login"
	      );
}

/** 
 * Ohjaa virheraporttiin
 */
function direct_wrong () { 
	header("Location: /pgCodesS/index.php?"
			. "login"
			. "&"
			. "unsuccessful_login"
	      );
}


/** Ota salasanan hash annetun emailin mukaan
 * @param $email string
 * @return string
 */
function get_passhash_for_email ( $email ) {
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

	$result = pg_query_params ( $dbconn,
			'SELECT passhash_md5
			FROM users
			WHERE email = $1',
			array ( $email ) 
			);

	/* 
	 * string $passhash_md5_original
	 */
	// to read the password from the result
	while ( $row = pg_fetch_row( $result ) ) {
		$passhash_md5_original = $row[0];
	}

	return $passhash_md5_original;
}


/** Varmista salasanan hash annetun emailin mukaan
 * @param $passhash_md5 string
 * @param $passhash_md5_original string
 * @return boolean
 */
function verify_passhash_for_email ( $passhash_md5, $passhash_md5_original ) {
	// unsuccessful attempts
	if ( $passhash_md5_original == $passhash_md5 )
		return true;
	else
		return false;
}

/** 
 * Tarkasta annetun datan aitous ja ainutlaatuisuus
 * @param $email string 
 * @param $password string
 */
function take_login_form ( $password, $email ) {
	$passhash_md5 = md5 ( $password );

	/** Tarkasta annetun datan aitous ja ainutlaatuisuus
	 */
	if ( validate( $email, $password ) ) {
		echo ("Validaation works");
		/**
		 * $passhash_original string
		 * $passhash_md5 string
		 */
		$passhash_original = get_passhash_for_email ( $email );
		if ( verify_passhash_for_email ( $passhash_md5, $passhash_original) ) {
			echo ("Verification works");
			// save data to sessions
			$_SESSION['login']['passhash_md5'] = $passhash_md5;
			$_SESSION['login']['email'] = $email;
			$_SESSION['login']['logged_in'] = 1;
			$_SESSION['login']['user_id'] = get_user_id ( $email );
			$_SESSION['login']['username'] = get_username ( $email );

			direct_right();
		}
		else
		{
			echo ("Wrong password given.");
			direct_wrong( );
		}
	}
	else 
	{
		direct_wrong();
	}
}

// Let's rock!

take_login_form ( $_POST['login']['password'], $_POST['login']['email'] );

ob_end_flush();

?>
