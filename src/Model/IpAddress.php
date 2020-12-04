<?php
namespace Gufo\Model;

class IpAddress
{
    protected $data = [
        'ipAddress' => null,
        'valid' => null,
        'protocol' => null,
        'domain' => null,
        'country_name' => null,
        'region_name' => null,
        'city' => null,
        'latitude' => null,
        'longitude' => null
    ];

    public function __construct($ipAddress)
    {
        $this->data['ipAddress'] = $ipAddress;

        if ($this->validate()) {
            $this->protocol();

            $this->domain();

            $this->geoLocate();
        }
    }

    public function validate()
    {
        if (filter_var($this->data['ipAddress'], FILTER_VALIDATE_IP)) {
            $this->data['valid'] = true;
        } else {
            $this->data['valid'] = false;
        }
        return $this->data['valid'];
    }

    public function protocol()
    {
        if (filter_var($this->data['ipAddress'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->data['protocol'] = 'IPV6';
        } else if (filter_var($this->data['ipAddress'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->data['protocol'] = 'IPV4';
        }
        return $this->data['protocol'];
    }

    public function domain()
    {
        return $this->data['domain'] = gethostbyaddr($this->data['ipAddress']);
    }

    public function geoLocate()
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/ipapi.txt");

        $results = file_get_contents("http://api.ipstack.com/{$this->data['ipAddress']}?{$apiKey}");
        $results = json_decode($results, "assoc");

        $this->data['country_name'] = $results['country_name'];
        $this->data['region_name'] = $results['region_name'];
        $this->data['city'] = $results['city'];
        $this->data['latitude'] = $results['latitude'];
        $this->data['longitude'] = $results['longitude'];
    }

    public function data()
    {
        return $this->data;
    }
}
