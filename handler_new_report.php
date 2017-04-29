<?php
session_start();

if (isset($_SESSION["email"]) && $_SESSION["password"]) {

    $email = $_SESSION["email"];
      $password = $_SESSION["password"];



    $query_string = "?r=new_report&";
    $query_string .= $_SERVER['QUERY_STRING'];

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://10.0.3.17' . $query_string . "&email=" . $email . "&password=" . $password . "&timestamp=" . time(),
        CURLOPT_USERAGENT => 'New Report'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources

    if ($resp == "ok")
    {
        header("location: index.php?p=ro");
    }
    else
    {
        echo $resp;
       // header("location: new_report.php?p=e");

    }

    curl_close($curl);
}
