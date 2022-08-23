<?php


function getBrand(){
    include '../api/configid.php';
    $arrdata = array();

    $data = $conn->query("SELECT id, name, slug, domain, aseet_namespace  FROM m_brand mb WHERE flag = 'Y'");
    
    $availdata = $data->num_rows > 0;

    if($availdata){
        $n = 0;
        while($p = $data->fetch_assoc()){
            $obj = new stdClass;
            $obj->id = $p['id'];
            $obj->name = $p['name'];
            $obj->slug = $p['slug'];
            $obj->domain = $p['domain'];
            $obj->aseet_namespace = $p['aseet_namespace'];
            $arrdata[$n] = $obj;
            $n++;
        }
        return $arrdata;
    }
    return "";
}

function getBrandDetail($slug=""){
    include '../api/configid.php';
    $data = $conn->query("SELECT id, name, slug, domain, aseet_namespace  FROM m_brand mb WHERE slug = '".$slug."' ");
    
    $availdata = $data->num_rows > 0;

    if($availdata){
        while($p = $data->fetch_assoc()){
            $obj = new stdClass;
            $obj->id = $p['id'];
            $obj->name = $p['name'];
            $obj->slug = $p['slug'];
            $obj->domain = $p['domain'];
            $obj->aseet_namespace = $p['aseet_namespace'];
            return $obj;
        }
    }
    return "";
}

function getContentBySlug($slug=""){
    include '../api/configid.php';
    $arrdata = array();
    
    $sql = "SELECT tc.id, date_namespace , time_namespace, tc.updated_at, tc.updated_who FROM t_content tc 
    INNER JOIN m_brand mb on mb.id  = tc.brand_id 
    WHERE mb.slug  = '".$slug."' and tc.flag ='Y' ";

    $data = $conn->query($sql);
    
    $availdata = $data->num_rows > 0;

    if($availdata){
        $n = 0;
        while($p = $data->fetch_assoc()){
            $obj = new stdClass;
            $obj->id = $p['id'];
            $obj->date = $p['date_namespace'];
            $obj->time = $p['time_namespace'];
            $obj->updatedat = $p['updated_at'];
            $obj->updatedwho = $p['updated_who'];
            $arrdata[$n] = $obj;
            $n++;
        }
        return $arrdata;
    }
    return "";
}

function getContentBodyById($id=""){
    include '../api/configid.php';
    $data = $conn->query("SELECT body_content FROM t_content WHERE id = '".$id."'");
    
    $availdata = $data->num_rows > 0;

    if($availdata){
        while($p = $data->fetch_assoc()){
            return $p['body_content'];
        }
    }
    return "";
}

function getAssetByContentId($contentid = ""){
    include '../api/configid.php';
    $arrdata = array();
    
    $sql = "SELECT 
    mb.domain, 
    mb.aseet_namespace, 
    tc.date_namespace,
    tc.time_namespace,
    ta.name
    FROM t_asset ta INNER JOIN
    t_content tc ON tc.id = ta.content_id INNER JOIN
    m_brand mb ON mb.id = tc.brand_id  
    WHERE ta.flag = 'Y'
    AND tc.id = '".$contentid."'
    ";

    $data = $conn->query($sql);
    
    $availdata = $data->num_rows > 0;

    if($availdata){
        $n = 0;
        while($p = $data->fetch_assoc()){
            $obj = new stdClass;
            $obj->domain = $p['domain'];
            $obj->asset_namespace = $p['aseet_namespace'];
            $obj->date_namespace = $p['date_namespace'];
            $obj->time_namespace = $p['time_namespace'];
            $obj->name = $p['name'];
            $arrdata[$n] = $obj;
            $n++;
        }
    }
    return $arrdata;
}

function getPathContent($id){

    include '../api/configid.php';

    $sql = "SELECT 
    mb.domain,
    mb.aseet_namespace,
    tc.date_namespace, 
    tc.time_namespace
    FROM t_content tc INNER JOIN
    m_brand mb ON mb.id = tc.brand_id 
    WHERE tc.id = '".$id."' ";

    $data = $conn->query($sql);

    $availdata = $data->num_rows > 0;
    if ($availdata){
        while($p = $data->fetch_assoc()){
            $obj = new stdClass;
            $obj->domain = $p['domain'];
            $obj->asset_namespace = $p['aseet_namespace'];
            $obj->date_namespace = $p['date_namespace'];
            $obj->time_namespace = $p['time_namespace'];
            return $obj;
        }
    }
    return "";
}

function updateContent($contentid = "", $bodycontent = "", $updatedwho){
    include '../api/configid.php';

    try {
        
        $sql = "UPDATE t_content SET body_content = '".$bodycontent."' WHERE id = '".$contentid."' ";

        if ($conn->query($sql) === TRUE) {
            return "success";
        } else {
            return "Error updating record: " . $conn->error;
        }

    } catch (\Throwable $th) {
        return $th;
    }
}
?>