<?php
require_once("../includes.php");
$feed = 70314; //co2 da un'università in australia

// Imposta l'URL e altre opzioni
$cosmos = new PachubeAPI($api_key);
$json = $cosmos->getFeed("json", $feed);
print $json;

?>