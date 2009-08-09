<?php
//$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");


$result = pg_prepare($dbconn, "query22", "SELECT passhash_md5 FROM users
        WHERE email=$1;");
//if(is_null($result)) {
//    throw new Exception("No valid Result");
//}
//

echo pg_last_error($dbconn);

//try{
//    $result = pg_prepare($dbconn, "query22", "SELECT passhash_md5 FROM users
//        WHERE email=$1;");
//    if($result){
//        $result->rayPrepared['query22'] = true;
//    }else{
//        throw new Exception('Prepared statement failed.');
//    }
//}catch(Exception $e){
//    echo $e->getMessage();
//}

//$result = pg_prepare($dbconn, "query22", "SELECT passhash_md5 FROM users
//    WHERE email=$1;");

// valmiina sisalla
//if (isset($_GET['email'])) {
//    $passhash_md5 = pg_execute($dbconn, "query22", array($_GET['email']));
//
//    if (!$passhash_md5) {
//        echo "An error occurred - hhhhhh!\n";
//    exit;
//    }
//
//    if ($passhash_md5 == $_GET['passhash_md5']) {
//        $logged_in = true;
//    } else {
//        $logged_in = false;
//    }
//}
//
// ekaa kertaa kirjautuu
if (isset($_POST['email'])) {
    $passhash_md5 = pg_execute($dbconn, "query22", array($_POST['email']));

    if (!$passhash_md5) {
        echo "An error occurred - hhhhhh!\n";
        exit;
    }

    if ($passhash_md5 == $_POST['passhash_md5']) {
        $logged_in = true;
    } else {
        $logged_in = false;
    }
}


// no pg_close() here
?>
