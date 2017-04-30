<?php
session_start();
require_once "server.php";

if (isset($_SESSION["email"]) && $_SESSION["password"]) {

    $url = "";
    require_once "upload.php";

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $url = "";
    if ($_FILES["image"]["error"] == 0) {
        $url = upload($_FILES["image"]);
    }

    $query_string = "?r=new_report";
    //$query_string .= $_SERVER['QUERY_STRING'];

    foreach ($_POST as $key => $value) {
        $query_string .= "&" . $key . "=" . str_replace(" ", "+", $value);
    }

// Get cURL resource
   $curl = curl_init();
// Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => server_info::URL . $query_string . "&email=" . $email . "&password=" . $password . "&timestamp=" . time() . "&image_url=" . $url,
        CURLOPT_USERAGENT => 'New Report'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources

    echo $resp;

    if ($resp == "ok") {
        header("location: index.php");
    } else {
        echo $resp;
   //     header("location: new_report.php?p=e");

    }

    curl_close($curl);
}
