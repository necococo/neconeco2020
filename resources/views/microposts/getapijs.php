
<?php
ini_set('display_errors',1);
$key = getenv('GMAP_API_KEY');

$url = 'https://maps.googleapis.com/maps/api/js?key='.urlencode($key);
// $url = 'https://maps.googleapis.com/maps/api/js?key='.$key;
header('Content-Type: text/javascript; charset=UTF-8');
// echo "'Content-Type': 'text/javascript; charset=UTF-8'";
// echo "";
echo file_get_contents($url);
// echo $url;
exit;