<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Simple Map</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            #map {
                height: 100%;
            }
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

        </style>
    </head>
    <body class="antialiased">
        <button onclick="updatePosition()">Update position</button>
        <div id="app"></div>
        <div id="map"></div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOdQVeifChSfE7YCp3blBwFB21wm5RupM&callback=initMap&v=weekly" defer></script>

        <script src="{{asset('js/app.js')}}"></script>

        <script>
            let marker;
            let map;
            let uluru;
            let lineCoordinates;
            
            function initMap() {
            
                uluru = { lat: -25.344, lng: 131.031 };

                lineCoordinates = [uluru];
            
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: uluru,
                });
                
                marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                });
            }

            window.initMap = initMap;

            function updatePosition(latLng)
            {
                // const latLng = { lat: -25.340, lng: 131.031 };
                marker.setPosition(latLng);
                map.setCenter(latLng);

                drawLine(latLng);

            }

            function drawLine(latLng)
            {
                // var lineCoordinates = [{ lat: -25.344, lng: 131.031 }];
                lineCoordinates.push(latLng);
                var linePath = new google.maps.Polyline({
                    path: lineCoordinates,
                    geodesic: true,
                    strokeColor: '#FF0000'
                });

                linePath.setMap(map);
            }
            

            



            Echo.channel('location')
            .listen('SendPosition', (e) => {
                updatePosition(e.location);
            });

        </script>
    </body>
</html>
