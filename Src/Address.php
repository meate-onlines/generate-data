<?php


namespace Random\Generate\Src;
use GuzzleHttp\Client;

class Address
{
    protected $data_source = [];

    public function __construct()
    {
        $data_source = json_decode(file_get_contents(__DIR__ . '/../lib/region.json'), true)['districts'];
        $this->data_source = array_column($data_source, null, 'name');
    }

    public function setProvince($province)
    {
        $data_source = $this->data_source[$province]['districts'] ?? [];
        if (!empty($data_source)){
            $this->data_source = array_column($data_source, null, 'name');
        }
        return $this;
    }

    public function setCity($city)
    {
        $data_source = $this->data_source[$city]['districts'] ?? [];
        if (!empty($data_source)){
            $this->data_source = array_column($data_source, null, 'name');
        }
        return $this;

    }


    public function get_coordinate_address() :array
    {
        if (empty($this->data_source)){
            return [];
        }
        $province   = $this->data_source[array_rand($this->data_source, 1)];
        $dis        = $province['districts'] ?? [];
        if (!empty($dis)){
            $coordinate = $dis[array_rand($dis, 1)];
        }else{
            $coordinate = $province;
        }
        list($longitude, $latitude) = array_values($coordinate['center']);
        $longitude = $longitude + $this->get_float();
        $latitude  = $latitude + $this->get_float();
        $key = config('generate.map_key');
        $url = config('generate.map_url') . '?' . 'key=' . $key . "&location=" . $longitude . ',' . $latitude;
        $request = new Client();
        $response = $request->get($url);
        $data = json_decode($response->getBody(), true);
        if ($data['status']){
           return [
              'longitude'  => $longitude,
              'latitude'   => $latitude,
              'address'   => $data['regeocode']['formatted_address'],
           ];
        }
        return [];
    }

    protected function get_float() :float
    {
        $float = mt_rand() / mt_getrandmax();
        return round($float / 100,6) * rand(-1,1);
    }
}