<?php
namespace Gufo\Model;

class Weather
{
    protected $lat;
    protected $lon;
    protected $curl;
    protected $apiKey;

    protected $weather = [
        'forecast' => [],
        'history' => []
    ];

    public function __construct($lat, $lon, $curl)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->curl = $curl;

        if (file_exists(dirname(__DIR__, 2).'/.env')) {
            $dotenv = new \Symfony\Component\Dotenv\Dotenv();
            $dotenv->load(dirname(__DIR__, 2).'/.env');
            $this->apiKey = $_ENV["WEATHER_API_KEY"];
        } else {
            $this->apiKey = "mock";
        }

        // $this->apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/weatherapi.txt");

        $this->forecast();
        $this->history();
    }

    private function forecast()
    {
        if ($this->apiKey != "mock") {
            $res = $this->curl->mcurl([
                "https://api.openweathermap.org/data/2.5/onecall?lat={$this->lat}&lon={$this->lon}&units=metric&exclude=hourly,minutely,current&appid={$this->apiKey}"
            ]);

            foreach ($res[0]->daily as $day) {
                array_push($this->weather['forecast'], [
                    'date' => date("yy-m-d", $day->dt),
                    'temp' => $day->temp->day,
                    'min' => $day->temp->min,
                    'max' => $day->temp->max,
                    'weather' => $day->weather[0]->main,
                    'weather-description' => $day->weather[0]->description,
                    'weather-icon' => $day->weather[0]->icon,
                    'day' => date("D", $day->dt)
                ]);
            }
        } else {
            array_push($this->weather['forecast'], [
                'date' => null,
                'temp' => null,
                'min' => null,
                'max' => null,
                'weather' => null,
                'weather-description' => null,
                'weather-icon' => null,
                'day' => null
            ]);
        }
    }

    private function history()
    {
        if ($this->apiKey != "mock") {
            $res = $this->curl->mcurl([
                "http://api.openweathermap.org/data/2.5/onecall/timemachine?lat={$this->lat}&lon={$this->lon}&dt=".strtotime('-1 day')."&units=metric&appid={$this->apiKey}",
                "http://api.openweathermap.org/data/2.5/onecall/timemachine?lat={$this->lat}&lon={$this->lon}&dt=".strtotime('-2 day')."&units=metric&appid={$this->apiKey}",
                "http://api.openweathermap.org/data/2.5/onecall/timemachine?lat={$this->lat}&lon={$this->lon}&dt=".strtotime('-3 day')."&units=metric&appid={$this->apiKey}",
                "http://api.openweathermap.org/data/2.5/onecall/timemachine?lat={$this->lat}&lon={$this->lon}&dt=".strtotime('-4 day')."&units=metric&appid={$this->apiKey}",
                "http://api.openweathermap.org/data/2.5/onecall/timemachine?lat={$this->lat}&lon={$this->lon}&dt=".strtotime('-5 day')."&units=metric&appid={$this->apiKey}",
            ]);

            foreach ($res as $day) {
                array_push($this->weather['history'], [
                    'date' => date("yy-m-d", $day->current->dt),
                    'temp' => $day->current->temp,
                    'weather' => $day->current->weather[0]->main,
                    'weather-description' => $day->current->weather[0]->description,
                    'weather-icon' => $day->current->weather[0]->icon,
                    'day' => date("D", $day->current->dt)
                ]);
            }
        } else {
            array_push($this->weather['history'], [
                'date' => null,
                'temp' => null,
                'weather' => null,
                'weather-description' => null,
                'weather-icon' => null,
                'day' => null
            ]);
        }
    }

    public function getForecast()
    {
        return $this->weather['forecast'];
    }

    public function getHistory()
    {
        return $this->weather['history'];
    }

    public function getAll()
    {
        return $this->weather;
    }
}
