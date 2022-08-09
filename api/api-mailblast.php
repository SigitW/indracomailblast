<?php
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "getdata"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input detected!";
  } else {
    $inputWebsite = $_POST["website"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastid WHERE status = 'Ready' AND subrek = 'subscribed' ";
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        $sql = "SELECT * FROM mailblast WHERE status = 'Ready' AND subrek = 'subscribed' ";
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastpandan WHERE status = 'Ready' AND subrek = 'subscribed' ";
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastindrstore WHERE status = 'Ready' AND subrek = 'subscribed' ";
      } else {
        $pesan = "Sorry! unidetified website";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $getData = $conn->query($sql);
      $contData = $getData->num_rows;
      if($contData == 0){
        $daJson["mailready"] = "";
      } else {
        $pid = 0;
        while($fetchData = $getData->fetch_assoc()){
          $daJson["mailready"][$pid]["id"] = $fetchData["id"];
          $daJson["mailready"][$pid]["email"] = $fetchData["email"];
          $daJson["mailready"][$pid]["status"] = $fetchData["status"];
          $pid++;
        }
      }
      $status = "Success";
      $pesan = "Data list loaded!";
    }
  }
} else if($do == "rmlist"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input found!";
  } else if(!isset($_POST["id"])){
    $pesan = "Sorry! no id input found!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputID = $_POST["id"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else if($inputID == ""){
      $pesan = "Sorry! ID cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        $sql = "UPDATE mailblastid SET status = 'Standby' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        $sql = "UPDATE mailblast SET status = 'Standby' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE id = '".$inputID."' ";
      } else {
        $pesan = "Sorry! Unidentified website!";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $conn->query($sql);
      $status = "Success";
      $pesan = "Successfully unset from the list";
    }
  }
} else if($do == "getdestination"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input not found!";
  } else if(!isset($_POST["search"])){
    $pesan = "Sorry! no search input not found!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputSearch = $_POST["search"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastid WHERE status = 'Standby' ";
        if($inputSearch != ""){
          $sql = $sql."AND email LIKE '%".$inputSearch."%' ";
        }
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        $sql = "SELECT * FROM mailblast WHERE status = 'Standby' ";
        if($inputSearch != ""){
          $sql = $sql."AND email LIKE '%".$inputSearch."%' ";
        }
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastpandan WHERE status = 'Standby' ";
        if($inputSearch != ""){
          $sql = $sql."AND email LIKE '%".$inputSearch."%' ";
        }
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        $sql = "SELECT * FROM mailblastindrstore WHERE status = 'Standby' ";
        if($inputSearch != ""){
          $sql = $sql."AND email LIKE '%".$inputSearch."%' ";
        }
      } else {
        $pesan = "Sorry! Unidentified website!";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $getStandby = $conn->query($sql);
      $countStandby = $getStandby->num_rows;
      if($countStandby == 0){
        $daJson["standby"] = "";
      } else {
        $pid = 0;
        while($fetchStandby = $getStandby->fetch_assoc()){
          $daJson["standby"][$pid]["id"] = $fetchStandby["id"];
          $daJson["standby"][$pid]["email"] = $fetchStandby["email"];
          $pid++;
        }
      }
      $status = "Success";
      $pesan = "Successfully loaded data";
    }
  }
} else if($do == "adddestination"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input detected!";
  } else if(!isset($_POST["id"])){
    $pesan = "Sorry! no id input detected!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputID      = $_POST["id"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website code cannot be empty!";
    } else if($inputID == ""){
      $pesan = "Sorry! id code cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        $sql = "UPDATE mailblastid SET status = 'Ready' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        $sql = "UPDATE mailblast SET status = 'Ready' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE id = '".$inputID."' ";
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE id = '".$inputID."' ";
      } else {
        $pesan = "Sorry! Unidentified website!";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $conn->query($sql);
      $status = "Success";
      $pesan = "Successfully set email to ready state";
    }
  }
} else if($do == "setgroup"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input detected!";
  } else if(!isset($_POST["code"])){
    $pesan = "Sorry! no code input detected!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputCode = $_POST["code"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else if($inputCode == ""){
      $pesan = "Sorry! code cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastid SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastid SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastid SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastid SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'adi@indraco.com' ";
          $sql = $sql."OR email = 'andry@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastid SET status = 'Ready' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblast SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblast SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblast SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblast SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblast SET status = 'Ready' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'adi@indraco.com' ";
          $sql = $sql."OR email = 'andry@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastpandan SET status = 'Ready' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'sgi.webdev@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastindrstore SET status = 'Ready' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else {
        $pesan = "Sorry! Unidentified website!";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $conn->query($sql);
      $status = "Success";
      $pesan = "Successfully set group email to ready state";
    }
  }
} else if($do == "unsetgroup"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no website input detected!";
  } else if(!isset($_POST["code"])){
    $pesan = "Sorry! no code input detected!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputCode = $_POST["code"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else if($inputCode == ""){
      $pesan = "Sorry! code cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastid SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastid SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastid SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastid SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'adi@indraco.com' ";
          $sql = $sql."OR email = 'andry@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastid SET status = 'Standby' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Supresso SG"){
        include "configsg.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblast SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblast SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblast SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblast SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblast SET status = 'Standby' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Pandangarden"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
          $sql = $sql."OR email = 'sgi.webdev@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'agus@indraco.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
          $sql = $sql."OR email = 'pristine@indraco.com' ";
          $sql = $sql."OR email = 'audrey.channitanda@ehl.ch' ";
          $sql = $sql."OR email = 'htd@indraco.com' ";
          $sql = $sql."OR email = 'mh@indraco.com' ";
          $sql = $sql."OR email = 'ivansantoso.priv@gmail.com' ";
          $sql = $sql."OR email = 'adi@indraco.com' ";
          $sql = $sql."OR email = 'andry@indraco.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastpandan SET status = 'Standby' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else if($inputWebsite == "Indracostore"){
        include "configid.php";
        if($inputCode == "Self"){
          $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Internals"){
          $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'sgi.webdev@indraco.com' ";
          $sql = $sql."OR email = 'yoggi.supresso@gmail.com' ";
        } else if($inputCode == "Directors"){
          $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
          $sql = $sql."OR email = 'as.sgiworld@gmail.com' ";
          $sql = $sql."OR email = 'design@indraco.com' ";
          $sql = $sql."OR email = 'marco@indraco.com' ";
        } else if($inputCode == "Owners"){
          $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE ";
          $sql = $sql."email = 'aldy.indraco@gmail.com' ";
        } else if($inputCode == "Members"){
          $sql = "UPDATE mailblastindrstore SET status = 'Standby' WHERE subrek = 'subscribed' ";
        } else {
          $pesan = "Unidentified code!";
          $daJson["message"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      } else {
        $pesan = "Sorry! Unidentified website!";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
      $conn->query($sql);
      $status = "Success";
      $pesan = "Successfully set group email to ready state";
    }
  }
} else {
  $pesan = "Sorry! no action detected!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
