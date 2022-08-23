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
    $pathcontent = getPathContent($id);

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
    
    //path content concate;
    $p = $pathcontent;
    $path = "/" . $p->domain . "/" . 
    $p->asset_namespace . "/" . $p->date_namespace . "/" . 
    $p->time_namespace;
    // end

    $result = array();
    $result['content'] = $datacontent;
    $result['asset'] = $arrayimg;
    $result['path'] = $path;

    $jsondata = json_encode($result);
    hasSuccess($jsondata);
}

if ($do == "update-content")
{
    $content = $_POST['content'];
    $id      = $_POST['id'];   
    $res     = updateContent($id, $content, '');

    if ($res == "success"){

        $pathcontent = getPathContent($id);
        //path content concate;
        $p = $pathcontent;
        $path = "/" . $p->domain . "/" . 
        $p->asset_namespace . "/" . $p->date_namespace . "/" . 
        $p->time_namespace . "/";
        // end

        $postdata = http_build_query(
            array(
                'token' => '1',
                'id' => '1',
                'content' => $content,
                'path' => $path,
                'do' => 'create-content'
            )
        );
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents('http://localhost/mbcontentservices/api/api-content.php', false, $context);
        echo $result;
    }
}

if ($do == "upload-asset"){
    $id     = $_POST['id'];
    $data   = $_POST['strimg'];
    $type   = $_POST['type'];

    // echo $data;

    $postdata = http_build_query(
        array(
            'token' => '1',
            'id' => '1',
            'content_id' => $id,
            'type' => $type,
            'strimg' => $data,
            'do' => 'upload-asset'
        )
    );
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents('http://localhost/mbcontentservices/api/api-content.php', false, $context);
    echo $result;
}