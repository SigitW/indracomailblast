<?php 
require_once('model.php');
require_once('response.php');

$do = $_GET['do'];
$base_url = "localhost"; // default must be ""
$img_folder = "img";

if ($do == "brand")
{
    $data = getBrand();
    $jsondata = json_encode($data);
    hasSuccess($jsondata);
}

if ($do == "load-detail")
{
    $slug = $_POST['slug'];

    $data = getBrandDetail($slug);
    if ($data == ""){
        hasInternalError($data);
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
    } else {
        $jsondata = json_encode($data);
        hasSuccess($jsondata);
    }
}

if ($do == "load-content-by-id")
{
    $id = $_POST['id'];

    $datacontent = getContentBodyById($id);
    $dataasset = getAssetByContentId($id);

    // generate array of img url;
    $arrayimg = array();
    $availasset = $dataasset != "" && count($dataasset);
    if ($availasset){
        foreach ($dataasset as $i => $asset) {
            $arrayimg[$i] = $base_url . "/" . $asset->domain . "/" . 
            $asset->asset_namespace . "/" . $asset->date_namespace . "/" . 
            $asset->time_namespace . "/" . $img_folder . "/". $asset->name;
        }
    }
    // end

    $result = array();
    $result['content'] = $datacontent;
    $result['asset'] = $arrayimg;

    $jsondata = json_encode($result);
    hasSuccess($jsondata);
}

if ($do == "update-content")
{
    $content = $_POST['content'];
    $id      = $_POST['id'];   
    $res     = updateContent($id, $content, '');

    

    $myfile = fopen("index.html", $content);
    echo $res;
    exit();
}