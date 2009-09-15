<?php 

/**
 * @file    index.php
 * @author  sam (sam@gmail.com)
 * @date    2009-08-30
 * @brief   Luo HTML rakenne sivustolle ja s\"{a}\"{a}nn\"{o}t sen toiminalle.
 *
 * Tiedosto sisaltaa sivun, johon muut tiedostot generoidaan.
 * Se sisaltaa lukuisia if -lauseita.
 * Se liittaa jQuery 1.3:sen tiedostosta `html_head_body.php`.
 *
 * Jarjestelman perustoiminnot kulkevat index.php:n kautta.
 * Ne ovat
 *
 * _____________________________________
 *               ETUSIVU
 * _____________________________________
 *
 *      NIMI                 GENEROIJA                     SELITYS
 *      ___________________________________________________________________________________
 *  1.  top_bar             /views/links_at_               Linkit sisaankirjaukseen, 
 *                          userbar.php                    sivustoinfoon
 *                                                         
 *  2.  login_by_session    /handlers/handle_login_
 *                          and_registration/login_
 *                          by_session.php                 Sisaankirjaus tarkistus
 *
 *  3.  search              /forms/search.php              Etsi kysymyksista
 *  4.  aikahaut            create_view()                  Jarjestaa kysymykset ajan mukaan
 *
 *  5.  paasisalto          create_content_without_        luo tavalliset ja
 *                          headings(),                    linkitetyt otsikot,
 *
 *                          /handlers/make_a_thread/       huomautukset,
 *                          thread_functions,php,          kaytetaan funktioissa
 *
 *                          create_notices(),              huomautukset,
 *                          create_logged_in_view(),       sisaankirjautumistila
 *                          create_ask_question_view(),    kysytila
 *                          create_about_view(),           yleistatila
 *                          create_in_question_view()      kysymystila
 *
 *
 * _____________________________________
 *       JARJESTELMAN KOMPONENTIT
 * _____________________________________
 *
 * Etusivun toiminnot sidotaan seuraaviin komponentteihin.
 * ** seuraavassa on jatetty poista funktioiden tiedoston nimet selkeyden vuoksi
 * ** se ei sisalla kaikkia funktioita, jotka parantavat kaytettavyytta 
 *
 *     NIMI             SIVU                SELITYS                        GENEROIJA
 *     ________________________________________________________________________________________
 *  1. about            ?about.php          mene tietoa sivustosta         create_about_view(), 
 *                                                                         /views/about.php
 *
 *  2. question_id      ?question_id        mene kysymykseen               create_in_question_view()
 *    2.1 sort          ?sort               aikajarjestys                  create_tab_box_question()
 *                                          parametrit: newest, 
 *                                                      oldest
 *                                          muokkaa kysymysta              create_moderator_box_for_
 *                                                                         a_question():
 *                                                                              delete_a_quesiton(),
 *                                                                              edit_question(),
 *                                                                              flag_question()
 *                                          lue vastaukset                 create_answers()
 *
 *  3. tag              ?tag                mene tagihakuun
 *    3.1 tab_tag       ?tag_tab            aikajarjestys                  create_tab_box_question
 *                                                                         _tags()
 *                                          parametrit: newest, oldest
 *
 *  4. username         ?username           mene kayttajahakuun            
 *    4.1. tab_user     ?tab_user           aikajarjestys                  create_tab_box_question_
 *                                                                         usernames()
 *                                          parametrit: newest, oldest
 *  5. search           ?search
 *  6. ask_question     ?ask_question       mene kysytilaan                /forms/lomake_ask_question.php
 *  7. login            ?login              mene sisaankirjaukseen         receive_login_form(),
 *                                                                         receive_registration_form()
 *  8. notices		?unsuccessful,	    anna huomautus		   /views/unsuccessful_notice.php,
 *			?successful					   /views/successful_notice.php
 *
 */




// Functions
include ("./handlers/header_functions.php");

// user info box for lists of questions and for answers
include ("./handlers/user_info_functions.php");

// We need output buffers to prevent headers from leaving before Sessions are 
// ended.
ob_start();

/**
 * Etusivu tarkistukset
 * \ingroup etusivu
 */
require ( './handlers/handle_login_and_registration/login_by_session.php' );
require ( './handlers/handle_login_and_registration/moderator_check.php' );

include ( './html_head_body.php' );

// debugging code must be inside HTML
// include( "debugging_code.php" );

include( './PATHs.php' );
?>

<div class="container"><!--/*{{{*/-->
<div class="header">
<div id="userbar">
<?php
require './views/links_at_userbar.php';
require './forms/lomake_search.php';
?>
</div>

<div id="logo">
<h1 id="logo">
<a href="index.php">
Forum
</a>
</h1>
</div>
</div>

<div id="navbar">
<div class='ask_question'>
<?php
require './views/ask_question_link.php';
?> 
</div>
</div>

<div id="mainbar">
<div class="container_two">
<?php

/** 
 * Luo huomautukset
 * \ingroup huomautukset
 */
function create_notices () {
	// Notices about successes and failures in the site
	require ('views/successful_notice.php');
	require ('views/unsuccessful_notice.php');

	// Recent questions at homepage
	if ( array_key_exists('successful_login', $_GET ) ) {
		require ( './handlers/searches/handle_questions_by_time.php' );
	}
	// Recent questions at homepage
	else if ( array_key_exists('successful_registration', $_GET ) ) {
		require ( './handlers/searches/handle_questions_by_time.php' );
	}
}

/** 
 * Luo perusn\"{a}kymym\"{a}
 * \ingroup search
 */
function create_view () {
	// search functions
	include ("./handlers/make_a_list_of_questions/make_a_list_of_questions_functions.php");
	include ("./handlers/make_a_list_of_questions/organize_a_list_of_questions_functions.php");

	// to sort the list of questions at the homepage
	if( empty( $_GET )
			OR $_GET['tab'] == 'newest'
			OR $_GET['tab'] == 'oldest' ) {
		require ( './handlers/searches/handle_questions_by_time.php' );
	}
	// tag search
	else if( $_GET['tab_tag'] == 'newest'
			OR $_GET['tab_tag'] == 'oldest' ) {
		require ( './handlers/searches/handle_questions_by_tag.php' );
	}
	// Tagged questions
	else if( array_key_exists( 'tag', $_GET ) ) {
		require ('./handlers/searches/handle_questions_by_tag.php');
	}
	// username search
	else if( $_GET['tab_user'] == 'newest'
			OR $_GET['tab_user'] == 'oldest' ) {
		require ( './handlers/searches/handle_questions_by_username.php' );
	}
	// Questions of a username
	else if( array_key_exists( 'username', $_GET ) ) {
		require ('./handlers/searches/handle_questions_by_username.php');
	}
	else if( array_key_exists( 'search', $_GET ) ) {
		require ('./handlers/searches/search_body.php');
	}
}


/** 
 * Ota kysymystunniste
 * \ingroup kysymys
 * @return integer
 */
function get_question_id_home ( ) {
	/* $pattern string
	 * $subject string
	 * $query string
	 * $question_id integer
	 */
	if ( !empty ( $_GET['question_id'] ) )
		return $_GET['question_id'];
	else if ( !empty ( $_SERVER['HTTP_REFERER'] ) ) 
	{
		// To redirect the user back to the question where he logged in
		$pattern = '/question_id=([^#&]*)/';
		$subject = $_SERVER['HTTP_REFERER'];
		// extract query from URL
		$query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
		parse_str ( $query, $params );
		$question_id = explode ( '=', $query );
		$question_id = $question_id[0];

		return $question_id;
	}
}


/** 
 * Luo sis\"{a}\"{a}nkirjautumisn\"{a}kym\"{a}
 * \ingroup login
 */
function create_logged_in_view () {
	// Login and Logout
	if (isset($_GET['login'])) {
		// to have login at userbar
		require './views/login.php';
	}
	// LOGOUT at USERBAR
	else if (isset($_GET['logout'])) {
		echo "Successful logout";
		session_destroy();
		header("Location: index.php");
	} 
}


/** 
 * Ota sis\"{a}\"{a}nkirjautumistila
 * \ingroup login
 * @return boolean
 */
function get_login_status () {
	if ( isset( $_SESSION['login']['logged_in'] ) )
		return true;
	else
		return false;
}


/** 
 * Luo kysy -nakyma
 * \ingroup kysy
 */
function create_ask_question_view () {
	// Ask question -view
	if ( isset( $_GET['ask_question'] ) ) {
		// change the layout by adding question form by getting data from 
		include './forms/lomake_ask_question.php';

		// LOGIN at the bottom of Ask_question
		if ( !get_login_status () )
			include( "./views/login.php" );
	}
}

/** 
 * Luo yleista -nakyma
 * \ingroup yleinen
 */
function create_about_view () {
	if ( array_key_exists ( 'about', $_GET ) )
		require './views/about.php';
}


/** 
 * Luo HTML vastaussailio
 * \ingroup kysymys
 * @param $question_id integer
 */
function create_answers_box ( $question_id ) {
	echo ("<table><tr><td>");
	// to sort the answers of the given question
	require ("./handlers/make_a_thread/fetch_answers.php");

	require ('./forms/lomake_answer.php');

	// LOGIN at the bottom
	if ( !get_login_status () )
		include( "./views/login.php" );
	echo ("</div>");    // to end container two

	echo ("</td><td><div class='right_bar'>");
	create_global_tag_count_box_for_a_question ( $question_id );
	echo ("</div></td></tr></table>");
}


/** 
 * Luo n\"{a}kym\"{a} kysymyksess\"{a}
 * \ingroup kysymys
 * @param $question_id integer
 */
function create_in_question_view ( $question_id ) {
	// Content with headers
	// Question selected by the user
	if( array_key_exists('question_id', $_GET ) ) 
	{
		if ( array_key_exists ( 'edit_question', $_GET ) ) 
			require ('./handlers/edit_question.php');
		else 
		{
			require ('./handlers/make_a_thread/fetch_a_question.php');
			create_answers_box ( $question_id );
		}
	}
}




/** 
 * Luo n\"{a}kym\"{a}t ilman otsikoita
 * \ingroup paasivu
 * @param $question_id integer
 */
function create_content_without_headings ( $question_id ) {
	// inside a question functions
	include ("./handlers/make_a_thread/thread_functions.php");
	create_notices ();
	create_logged_in_view ();
	create_ask_question_view ();
	create_about_view ();

	create_in_question_view ( $question_id );
}



// Let's fire!

/** 
 * Luo p\"{a}\"{a}n\"{a}kym\"{a} otetulle kysymystunnisteelle ja luo
 * sis\"{a}lt\"{o}, jolla ei ole otsikoita
 */
create_view ();
create_content_without_headings ( get_question_id_home () );

?>
</div>
</div>
<!--/*}}}*/-->
</body>
</html>

<?php
// http://www.php.net/manual/en/function.session-regenerate-id.php#85433
ob_end_flush();

?>
