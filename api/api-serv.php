<?php
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "getisset"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no web input found!";
  } else {
    $inputWebsite = $_POST["website"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastid WHERE status = 'Ready' AND subrek = 'subscribed' LIMIT 1 ";
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        $sql = "SELECT * FROM mailblast WHERE status = 'Ready' AND subrek = 'subscribed' LIMIT 1 ";
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastpandan WHERE status = 'Ready' AND subrek = 'subscribed' LIMIT 1 ";
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastindrstore WHERE status = 'Ready' AND subrek = 'subscribed' LIMIT 1 ";
      } else {
        $pesan = "Sorry! unidetified website";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $getData = $conn->query($sql);
      $countData = $getData->num_rows;
      if($countData == 0){
        $daJson["ready"] = "";
      } else {
        $pid = 0;
        while($fetchData = $getData->fetch_assoc()){
          $daJson["ready"][$pid]["id"] = $fetchData["id"];
          $daJson["ready"][$pid]["email"] = $fetchData["email"];
          $daJson["ready"][$pid]["name"] = $fetchData["nama"];
          $daJson["ready"][$pid]["status"] = $fetchData["status"];
          $pid++;
        }
      }
      $status = "Success";
      $pesan = "Data loaded!";
    }
  }
} else {
  $pesan = "Sorry! action is not detected!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
