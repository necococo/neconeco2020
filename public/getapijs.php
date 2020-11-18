
<?php
$key = getenv("GMAP_API_KEY");
$url = "https://maps.googleapis.com/maps/api/js?key=".urlencode($key);
header("Content-Type: text/javascript; charset=UTF-8");
echo file_get_contents($url);
?>