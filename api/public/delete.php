<?php
include_once '../controls/Storage.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD']; 
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    http_response_code(200);
    die();
}

$id = isset($_GET['id']) ? $_GET['id'] : die();

$datareq = (object)array('id' => $id);
$storage = new Storage($datareq);

if($storage->delete()) {
    http_response_code(202);
} else {
    $storage->badRequest();
}
