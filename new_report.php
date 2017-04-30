<?php
require_once "get_all_species.php";
$json = get_all_species();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New report</title>
    <?php require_once "headers.php"; ?>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

</head>
<body>
<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: login.php");
}
?>
<?php require_once "navbar.php"; ?>

<?php
if (isset($_GET["p"])) {
    $code = $_GET["p"];
    if ($code == "e") {
        ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> An error occur
        </div>
        <?php
    }
} ?>

<div class="container">
    <h2>New report</h2>
    <form class="form-horizontal" method="post" action="handler_new_report.php" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-sm-2" for="species">Type of species:</label>
            <div class="col-sm-10">
                <select class="form-control" id="species" name="id_species">

                    <?php

                    foreach ($json as $row) {
                        $element = json_decode($row, true);
                        echo "<option value=" . $element["idTaxon"] . ">" . $element["name"] . "</option>";
                    }
                    ?>
                </select>

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="damage">Type of damage:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="damage" placeholder="Enter what happened"
                       name="damage">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="image">Photo:</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="image"
                       name="image">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="CoordinateLabel">Coordinate:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="coordinates" id="Coordinate" required>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 ">
                <div class="col-sm-10">
                    <input type='button' onclick="SetMapByText()" class="btn btn-primary" name='update'
                           value='Update map'>
                    <input type='button' onclick="SetMapByPosition()" class="btn btn-primary" name='autoPosition'
                           value='Current position'>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="MapLabel"></label>
            <div class="col-sm-10">
                <div id="map"></div>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-4" for="solution">Have you found a solution?</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="2" name="solution" id="solution"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>

    <br>
    <br>
</div>


<script type="text/javascript">

    var map;
    var markers = [];
    var currentLatitude;
    var currentLongitude;

    function initMap(lat=0, long=0) {

        var uluru = {lat: 45.5472729, lng: 11.5471119};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: uluru
        });

        marker = new google.maps.Marker({
            // position: uluru,
            //   map: map
        });


        map.addListener('click', function (e) {


            var latitude = e.latLng.lat();
            var longitude = e.latLng.lng();

            document.getElementById("Coordinate").value = latitude + " " + longitude;

            placeMarkerAndPlanTo(e.latLng, map);

        });
    }

    function SetMapByPosition() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Your browser is not supported");
        }
    }


    function showPosition(position) {
        var output = position.coords.latitude + " " + position.coords.longitude;

        placeMarkerAndPlanTo(null, map, position.coords.latitude, position.coords.longitude);
        var Coordinates = document.getElementById("Coordinate").value = output;

    }

    function SetMapByText() {
        var Coordinates = document.getElementById("Coordinate").value;
        Coordinates = Coordinates.replace(',', '');
        document.getElementById("Coordinate").value = Coordinates;
        var splitted = Coordinates.split(" ");
        if (splitted.length !== 2) {
            alert("Invalid coordinates, use xxx.xxx yy.yyy format");
        }
        else
            placeMarkerAndPlanTo(null, map, splitted[0], splitted[1]);
    }

    function placeMarkerAndPlanTo(latLng, map, lat, lon) {
        if (latLng === null) {
            latLng = new google.maps.LatLng(lat, lon)
        }
        marker.setMap(null);

        marker = new google.maps.Marker({
            position: latLng,
            map: map

        });


        if (map.getZoom() === 5) {
            map.setCenter(latLng);
            map.setZoom(18);
        }
    }


    function clearMarkers(map) {
        setMapOnAll(null);
    }

    $(document).ready(function () {
        SetMapByPosition();
    });

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXZYq-f8Y5LlM2nT4x8QCnd6Rnsxl97dc&callback=initMap"></script>

</body>
</html>
