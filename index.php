<?php session_start();
require_once "get_all_report.php";
$json = get_all_reports();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <?php require_once "headers.php"; ?>
    <style>
        #map {
            height: 600px;
            width: 100%;

        }

        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>

</head>
<body>
<?php require_once "navbar.php"; ?>


<

    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 3,
            center: {lat: 45, lng: 11}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = [];
        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.

        <?php
        $i = 0;
        $dictionary = array();

        foreach ($json as $row) {
            $element = json_decode($row, true);
            $id = $element["id"];
            $dictionary[$i] = $id;
            echo "labels.push($i);";
            $i++;
        }
        ?>

        var markers = locations.map(function (location, i) {
            return new google.maps.Marker({
                position: location,
                label: (labels[i % labels.length].toString())
            });
        });


        markers.forEach(function (element) {
            element.addListener('click', function () {
                var code = 0;
                switch (parseInt(element.getLabel())) {
                <?php
                    foreach ($dictionary as $key => $item) {
                        echo "
                            case $key:
                            code = $item;
                            break;";
                    }
                    ?>
                }

                window.location.href = 'show_report.php?id=' + code;

            });
        });


        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }
    var locations = [
        <?php
        foreach ($json as $row) {
            $element = json_decode($row, true);

            echo "{lat: " . $element["locationX"] . ", lng: " . $element["locationY"] . "},";
        }
        ?>
    ]
</script>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXZYq-f8Y5LlM2nT4x8QCnd6Rnsxl97dc&callback=initMap">
</script>

<script>

</script>


</body>

</html>