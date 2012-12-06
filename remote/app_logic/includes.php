<?php
require_once("api/class.api.php");
require_once("api/patchube.api.php");
require_once("parser/cosm_parser.php");
//cosm api key of doruchan
$api_key = 'TLAPjWt51gd_rGA5UlvgmCUlKaKSAKxFbXVrMzg1QXpMOD0g';
$cosm_base_url = "http://cosm.com/feeds/";

$parsed_ids = json_decode('["co2","co"]', true);
?>