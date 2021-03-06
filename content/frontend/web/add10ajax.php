<?php
require_once("./_config.php");
require_once("./_list.php");
require_once("./_curl.php");

$resp = array("newNames" => array());

# list all names

$names_url = "http://" . get_ip() . "/api/names";
$ch = curl_init($names_url);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Host: " . $app_hostname));
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$all_names = file("names.txt");
$num_lines = count($all_names);

for ($i = 0; $i < 10; $i++) {
    $rando_line = rand(1, $num_lines) - 1;
    $name = rtrim($all_names[$rando_line]);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "=".$name);
    curl_exec($ch);
    $resp["newNames"][] = $name;
}

$resp["allNames"] = list_names($app_hostname);

print json_encode($resp);
?>
