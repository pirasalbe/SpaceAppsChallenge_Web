<?php
session_start();

if (isset($_REQUEST["id"])) {
    $report_id = $_REQUEST["id"];
    $query_string = "?r=show_report&report_id=" . $report_id;

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://10.0.3.17' . $query_string,
        CURLOPT_USERAGENT => 'Show Report'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);


    $json = json_decode($resp, true);
    //coordinate locationX/Y timestamp species_name damages solution

    $json = $json[0];
    $json = json_decode($json, true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "headers.php"; ?>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>

<?php require_once "navbar.php"; ?>

<div class="container">


    <div class="jumbotron" align="center">
        <h1><?php echo $json["name"]; ?></h1>
    </div>

    <div class="row marketing">
        <div class="col-lg-4">
            <h4>Date</h4>
            <p><?php echo $json["timespan"]; ?></p>

            <h4>Damage</h4>
            <p><?php if ($json["damage"] == "") {
                    echo "None";
                } else {
                    echo $json["damage"];
                } ?></p>

            <h4>Trust</h4>
            <p><?php echo $json["trust"]; ?></p>


        </div>

        <div class="col-lg-4">
            <h4>User</h4>
            <p><?php echo $json["email"]; ?></p>

            <h4>Solution</h4>
            <p><?php if ($json["solution"] == "") {
                    echo "None";
                } else {
                    echo $json["solution"];
                } ?></p>

        </div>

        <div class="col-lg-4">
            <img src="<?php echo $json["image_url"]; ?>" class="img-fluid" alt="Photo">
        </div>


    </div>

    <div id="map"></div>


</div> <!-- /container -->


<script type="text/javascript">

    var map;
    var markers = [];

    var lat = <?php echo $json["locationX"] ?> ;
    var lng = <?php echo $json["locationY"] ?> ;


    function initMap() {

        var uluru = {lat: lat, lng: lng};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: uluru
        });

        marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }


</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXZYq-f8Y5LlM2nT4x8QCnd6Rnsxl97dc&callback=initMap"></script>

</body>
</html>