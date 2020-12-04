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
        $this->apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/weatherapi.txt");

        $this->forecast();
        $this->history();
    }

    private function forecast()
    {
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
    }

    private function history()
    {
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
