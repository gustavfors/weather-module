<?php

namespace Gufo\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Gufo\Model\Weather;
use Gufo\Model\IpAddress;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $db = "not active";

    public function initialize() : void
    {
        $this->db = "active";
        $this->page = $this->di->get("page");
    }

    public function indexActionGet()
    {
        if ($this->di->request->getGet('ipAddress')) {
            $ipAddress = new IpAddress($this->di->request->getGet('ipAddress'));
            $data = $ipAddress->data();

            if (!$data['valid']) {
                $this->page->add('weather/error', [
                    'message' => "You have provided an invalid ip address.",
                    'ipAddress' => $this->di->request->getGet('ipAddress') ?? ''
                ]);
                return $this->page->render(["title" => "WeatherError"]);
            }

            if ($data['latitude'] == null || $data['longitude'] == null) {
                $this->page->add('weather/error', [
                    'message' => "You have provided a valid ip address, but weather/locational data can not be extracted from it.",
                    'ipAddress' => $this->di->request->getGet('ipAddress') ?? ''
                ]);
                return $this->page->render(["title" => "WeatherError"]);
            }

            $weather = new Weather($data['latitude'], $data['longitude'], $this->di->get('curl'));

            $forecast = $weather->getForecast();
            $history = $weather->getHistory();

            $this->page->add('weather/show', [
                'forecast' => $forecast,
                'history' => $history,
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude'],
                'country' => $data['country_name'],
                'region' => $data['region_name'],
                'city' => $data['city'],
                'ipAddress' => $this->di->request->getGet('ipAddress') ?? ''
            ]);
        } else {
            $this->page->add('weather/index');
        }

        return $this->page->render(["title" => "Weather"]);
    }
}
