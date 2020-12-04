<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "curl" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Gufo\Model\Curl();
                return $obj;
            }
        ],
    ],
];
