<?php

namespace Anax\View;

?>


<script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>

<h1>Weather Information</h1>
<p>Enter an IP Address and recieve weather information!</p>
<form action="">
    <input type="text" name="ipAddress" placeholder="ip..." value="<?= $ipAddress; ?>">
    <button type="submit">Show</button>
</form>

<h1>Location:</h1>
<p>Country: <?= $country; ?></p>
<p>Region: <?= $region; ?></p>
<p>City: <?= $city; ?></p>
<p>Position: <?= $latitude; ?>, <?= $longitude; ?></p>

<div class="map-container">

    <div id="map"></div>

</div>

<script>
    mapboxgl.accessToken='pk.eyJ1IjoiZ3VmbyIsImEiOiJja2h0NWV0dzk0Z2d4MnNsNjAzMmpwbDNvIn0.dtjL8ECaiQ98RkUyrnuW6w';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [<?= $longitude; ?>, <?= $latitude; ?>], // starting position [lng, lat]
        zoom: 12 // starting zoom
    });

    var marker = new mapboxgl.Marker()
    .setLngLat([<?= $longitude; ?>, <?= $latitude; ?>])
    .addTo(map);
</script>


<h1>Weather Forecast</h1>

<div class="weather-forecast">
    <?php foreach ($forecast as $day) : ?>
        <div class="weather-forecast-item">
            
            <div class="weather-forecast-flex-item">
                <div><?= $day['day']; ?></div>
                <div><?= $day['date']; ?></div>
                
            </div>
            <div class="weather-forecast-item-box">
                <div class="weather">
                    <?= $day['weather']; ?>
                </div>
                <div class="weather-icon">
                    <img src="http://openweathermap.org/img/wn/<?= $day['weather-icon']; ?>@2x.png" alt="<?= $day['weather']; ?>">
                </div>
                <div class="temp">
                    <?= $day['temp']; ?>°C
                </div>
            </div>
            <div class="weather-forecast-flex-item">
                <div>Min <?= $day['min']; ?>°C</div>
                <div>Max <?= $day['max']; ?>°C</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h1>Weather History</h1>

<div class="weather-forecast">
    <?php foreach ($history as $day) : ?>
        <div class="weather-forecast-item">
            
            <div class="weather-forecast-flex-item">
                <div><?= $day['day']; ?></div>
                <div><?= $day['date']; ?></div>
                
            </div>
            <div class="weather-forecast-item-box">
                
                
                <div class="weather">
                    <?= $day['weather']; ?>
                </div>
                <div class="weather-icon">
                    <img src="http://openweathermap.org/img/wn/<?= $day['weather-icon']; ?>@2x.png" alt="<?= $day['weather']; ?>">
                </div>
                <div class="temp">
                    <?= $day['temp']; ?>°C
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>