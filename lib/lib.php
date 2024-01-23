<?php
session_start();

include_once '../lib/dao.php';
include_once '../lib/model.php';

$d = new dao();
$m = new model();
$con=$d->dbCon();
$default_time_zone="Asia/Calcutta";
date_default_timezone_set($default_time_zone);
header('Access-Control-Allow-Origin: *');  //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
$base_url=$m->base_url();

$header = apache_request_headers();
$key = $header["key"];
$keydb ="123";



?>