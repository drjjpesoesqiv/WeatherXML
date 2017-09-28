<?php

define('API_KEY', 'YOUR API KEY');
define('BASE_URL', 'http://api.openweathermap.org/data/2.5/weather?zip={zip},us&appid={api_key}&units={units}&mode=xml');

$options = [
  'api_key' => API_KEY,
  'units'   => 'imperial'
];

try
{
  if ( ! isset($argv[1]))
    throw new \Exception('must provide zip code');

  $options['zip'] = $argv[1];

  $url = BASE_URL;
  foreach ($options as $key => $val)
    $url = str_replace("{{$key}}", $val, $url);

  $data = file_get_contents($url);
  if ($data === FALSE)
    throw new \Exception('error retrieving weather information');

  $xml = new SimpleXMLElement($data);
  if ($xml === FALSE || ! isset($xml->temperature['value']))
    throw new \Exception('error parsing weather information');
  
  echo $xml->temperature['value'] . PHP_EOL;
}
catch (\Exception $e)
{
  echo $e->getMessage();
  echo PHP_EOL;
}
