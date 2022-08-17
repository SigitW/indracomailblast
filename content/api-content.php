<?php 
require_once('model.php');
require_once('response.php');

$do = $_GET['do'];

if ($do == "brand")
{
    $data = getBrand();
    $jsondata = json_encode($data);
    echo $jsondata;
    exit();
}

if ($do == "load-detail")
{
    $slug = $_POST['slug'];

    $data = getBrandDetail($slug);
    if ($data == ""){
        hasInternalError($data);
        exit();
    } else {
        $jsondata = json_encode($data);
        hasSuccess($jsondata);
    }
}

if ($do == "load-content")
{
    $slug = $_POST['slug'];

    $data = getContentBySlug($slug);
    if ($data == ""){
        hasInternalError($data);
        exit();
    } else {
        $jsondata = json_encode($data);
        hasSuccess($jsondata);
    }
}