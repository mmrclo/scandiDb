<?php
include_once '../controls/Storage.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

$requesttype = $_SERVER['REQUEST_METHOD'];

$datareq = json_decode(file_get_contents("php://input"));

$storage = new Storage($datareq);

echo $storage->selectAll();
