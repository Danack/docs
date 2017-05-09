<?php


require_once __DIR__ . "/../src/Weather.php";


$city = 'Bristol';
$country = 'GB';


if (array_key_exists('city', $_REQUEST) === true) {
    $city = $_REQUEST['city'];
}

$wf = getWeatherFromOpenWeatherMap($city, $country);

$dataEntries = [];
$count = 0;
foreach ($wf->weatherEntries as $weatherEntry) {
    $dataEntry = [];
    $dataEntry['dt'] = $weatherEntry->time;
    $dataEntry['time'] = $weatherEntry->time_text;
    $dataEntry['temp'] = $weatherEntry->temp;
    $dataEntry['description'] = $weatherEntry->weatherConditions[0]->main;
    $dataEntry['icon'] = $weatherEntry->weatherConditions[0]->getIconUrl();
    $dataEntries[] = $dataEntry;

    $count++;
    if ($count >= 5) {
        break;
    }
}

echo json_encode($dataEntries, JSON_PRETTY_PRINT);

exit(0);

$json = <<< JSON
[{
  "dt": 12345,
  "temp": "20",
  "time": "Wed 3pm",
  "description": "warm grey",
  "icon": "http://openweathermap.org/img/w/10d.png"
}]
JSON;

echo $json;
