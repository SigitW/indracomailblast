<?php

$arrdata = array();

function getBrand(){
    include '../api/configid.php';
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
    
    $sql = "SELECT tc.id, date_namespace , time_namespace, tc.updated_at, tc.updated_who FROM t_content tc 
    INNER JOIN m_brand mb on mb.id  = tc.brancd_id 
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
?>