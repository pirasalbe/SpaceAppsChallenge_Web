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
<?php require_once "navbar.php"; ?>
<div class="container">
    <h2>New report</h2>
    <form class="form-horizontal" method="get" action="handler_new_report.php">
        <div class="form-group">
            <label class="control-label col-sm-2" for="specie_type">Type of specie:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="specie_type"
                       placeholder="Enter the type of the specie you found" name="specie_type">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="damage_type">Type of damage:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="damage_type" placeholder="Enter what happened"
                       name="damage_type">
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
                           value='Aggiorna mappa'>
                    <input type='button' onclick="SetMapByPosition()" class="btn btn-primary" name='autoPosition'
                           value='Ottieni Posizione'>
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

            placeMarkerAndPanTo(e.latLng, map);

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

        placeMarkerAndPanTo(null, map, position.coords.latitude, position.coords.longitude);
        var Coordinates = document.getElementById("Coordinate").value = output;

    }

    function SetMapByText() {
        var Coordinates = document.getElementById("Coordinate").value;
        Coordinates = Coordinates.replace(',', '');
        document.getElementById("Coordinate").value = Coordinates;
        var splitted = Coordinates.split(" ");
        if (splitted.length !== 2) {
            alert("Le coordinate non sono inserite correttamente\nInserisce la latitudine xx.xxx e la longitudine yy.yyy separati da uno spazio");
        }
        else
            placeMarkerAndPanTo(null, map, splitted[0], splitted[1]);
    }

    function placeMarkerAndPanTo(latLng, map, lat, lon) {
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
