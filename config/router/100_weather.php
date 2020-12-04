<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "weather",
            "mount" => "weather",
            "handler" => "\Gufo\Controller\WeatherController",
        ],
    ]
];
