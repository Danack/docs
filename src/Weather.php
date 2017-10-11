<?php

include_once __DIR__ . "/../../keys.php";

class Coordinate
{
    public $latitude;

    public $longitude;

    /**
     * Coordinate constructor.
     * @param $latitude
     * @param $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    public static function fromArray($data)
    {
        return new self($data['lat'], $data['lon']);
    }
}

class City {

    public $id;
    public $name;
    public $coordinate;
    public $country;

    /**
     * City constructor.
     * @param $id
     * @param $name
     * @param $coordinate
     * @param $country
     */
    public function __construct($id, $name, Coordinate $coordinate, $country)
    {
        $this->id = $id;
        $this->name = $name;
        $this->coordinate = $coordinate;
        $this->country = $country;
    }

    public static function fromArray($data)
    {
        return new self(
            $data['id'],
            $data['name'],
            \Coordinate::fromArray($data['coord']),
            $data['country']
        );
    }
}


class WeatherCondition {

    public $id;
    public $main;
    public $description;
    public $icon;

    /**
     * WeatherCondition constructor.
     * @param $id
     * @param $main
     * @param $description
     * @param $icon
     */
    public function __construct($id, $main, $description, $icon)
    {
        $this->id = $id;
        $this->main = $main;
        $this->description = $description;
        $this->icon = $icon;
    }

    /**
     * @param $data
     * @return WeatherCondition
     */
    public static function fromArray($data)
    {
        return new self(
            $data['id'], //list.weather.id Weather condition id
            $data['main'], //list.weather.main Group of weather parameters (Rain, Snow, Extreme etc.)
            $data['description'], //list.weather.description Weather condition within the group
            $data['icon'] //list.weather.icon Weather icon id
        );
    }

    /**
     * @return string
     */
    public function getIconUrl() {
        return sprintf('http://openweathermap.org/img/w/%s.png', $this->icon);
    }
}



class WeatherEntry
{
    public $time;
    public $time_text;
    public $temp;
    public $temp_min;
    public $temp_max;

    /** @var WeatherCondition[]  */
    public $weatherConditions = [];

    public $wind_speed;
    public $wind_direction;
    public $clouds;

     /**
     * WeatherEntry constructor.
     * @param $time
     * @param $time_text
     * @param $temp
     * @param $temp_min
     * @param $temp_max
     * @param $weather_id
     * @param $weather_main
     * @param $weather_description
     * @param $weather_icon
     * @param $wind_speed
     * @param $wind_direction
     * @param $clouds
     */
    public function __construct($time, $time_text, $temp, $temp_min, $temp_max, $weatherConditions, $wind_speed, $wind_direction, $clouds)
    {
        $this->time = $time;
        $this->time_text = $time_text;
        $this->temp = $temp;
        $this->temp_min = $temp_min;
        $this->temp_max = $temp_max;
        $this->weatherConditions = $weatherConditions;
        $this->wind_speed = $wind_speed;
        $this->wind_direction = $wind_direction;
        $this->clouds = $clouds;
    }

    public static function fromArray($data) {
        $time = $data['dt']; //Time of data forecasted, unix, UTC
        $time_text = $data['dt_txt'];
        $temp = $data['main']['temp']; //Temperature. Unit Default: Kelvin, Metric: Celsius, Imperial: Fahrenheit.
        $temp_min = $data['main']['temp_min']; //list.main.temp_min //Minimum temperature at the moment of calculation.
        $temp_max = $data['main']['temp_max'];//list.main.temp_max //Maximum temperature at the moment of calculation.

        $weatherConditions = [];

        foreach ($data['weather'] as $weatherConditionData) {
            $weatherConditions[] = WeatherCondition::fromArray($weatherConditionData);

        }

        $wind_speed = $data['wind']['speed']; // Wind speed. Unit Default: meter/sec, Metric: meter/sec, Imperial: miles/hour.

        $wind_direction = $data['wind']['deg']; // Wind direction, degrees (meteorological)
        $clouds = $data['clouds']['all'];


        return new self($time, $time_text, $temp, $temp_min, $temp_max, $weatherConditions, $wind_speed, $wind_direction, $clouds);
    }
}

class WeatherForecast {

    /** @var  \City */
    public $city;

    /** @var WeatherEntry[]  */
    public $weatherEntries = [];

    /**
     * WeatherForecast constructor.
     * @param City $city
     * @param $weatherEntries
     */
    public function __construct(City $city, $weatherEntries) {
        $this->city = $city;
        $this->weatherEntries = $weatherEntries;
    }

    public static function fromData($data)
    {
        $city = \City::fromArray($data['city']);
        $weatherEntries = [];

        foreach ($data['list'] as $weatherEntryData) {
            $weatherEntries[] = WeatherEntry::fromArray($weatherEntryData);
        }

        return new self($city, $weatherEntries);
    }
}

//function getWeatherFromApixu()
//{
//    $params = [
//        'key' => WEATHER_APIXU_KEY,
//        'q' => 'BS1 5PY',
//        'days' => 5,
//        'hour' => 15,
//    ];
//
//    $url = "http://api.apixu.com/v1/forecast.json?" . http_build_query($params);
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//    $json_output = curl_exec($ch);
//    $weatherData = json_decode($json_output, true);
//
//    return WeatherForecast::fromData($weatherData);
//}


function getWeatherFromOpenWeatherMap($city, $country)
{
    $params = [
        'APPID' => WEATHER_OPENWEATHER_API_KEY,
        'q' => sprintf('%s,%s', $city, $country),
        'units' => 'metric'
//        'days' => 5,
//        'hour' => 15,
    ];
    // api.openweathermap.org/data/2.5/forecast/daily?q={city name},{country code}&cnt={cnt}

    $url = "http://api.openweathermap.org/data/2.5/forecast?" . http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json_output = curl_exec($ch);
    $weatherData = json_decode($json_output, true);

    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($statusCode !== 200) {
        throw new \Exception("Failed to retrieve weather forecast from $url");
    }

    return WeatherForecast::fromData($weatherData);
}

//$weather = getWeatherFromOpenWeatherMap();
//
//var_dump($weather);