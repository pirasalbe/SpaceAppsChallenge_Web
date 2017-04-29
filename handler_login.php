<?php
session_start();

if (isset($_POST["email"]) && $_POST["password"]) {


    $email = $_POST["email"];
    $password = hash("sha256", $_POST["password"]);

    $query_string = "?r=login&";

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://10.0.3.17' . $query_string . "email=" . $email . "&password=" . $password,
        CURLOPT_USERAGENT => 'Login'
    ));

// Send the request & save response to $resp
    $resp = curl_exec($curl);
    curl_close($curl);

    if ($resp == "ok") {
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("location: index.php");
    } else {
        header("location: login.php?p=lno");
    }

// Close request to clear up some resources

}
