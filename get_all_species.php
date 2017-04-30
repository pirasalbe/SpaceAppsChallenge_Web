<?php
require_once "server.php";

function get_all_species()
{
    $query_string = "?r=all_species";

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => server_info::URL . $query_string,
        CURLOPT_USERAGENT => 'All Species'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);


    $json = json_decode($resp, true);

    return $json;

}