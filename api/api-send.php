<?php
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');
require('PHPMailer/Exception.php');
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "send"){
  if(!isset($_POST["website"])){
    $pesan = "Sorry! no web input detected!";
  } else if(!isset($_POST["id"])){
    $pesan = "Sorry! no id input detected!";
  } else {
    $inputWebsite = $_POST["website"];
    $inputID = $_POST["id"];
    if($inputWebsite == ""){
      $pesan = "Sorry! website cannot be empty!";
    } else if($inputID == ""){
      $pesan = "Sorry! id cannot be empty!";
    } else {
      if($inputWebsite == "Supresso ID"){
        //Supresso ID
      } else if($inputWebsite == "Supresso SG"){
        //Supresso SG
        include "configsg.php";
      } else if($inputWebsite == "Pandangarden"){
        //Pandangarden
        include "configid.php";
      } else if($inputWebsite == "Indracostore"){
        //Indracostore
        include "configid.php";
        $getMailList = $conn->query("SELECT * FROM mailblastindrstore WHERE status = 'Ready' AND subrek = 'subscribed' LIMIT 1 ");
        $countMailList = $getMailList->num_rows;
        if($countMailList == 0){
          $pesan = "Sorry! account not found!";
        } else {
          $fetchMailList = $getMailList->fetch_assoc();
          $memberID = $fetchMailList["id"];
          $memberEmail = $fetchMailList["email"];
          $memberNama = $fetchMailList["nama"];
          $memberStatus = $fetchMailList["status"];
          if($memberID != $inputID){
            $pesan = "Incorect mail ID!";
          } else {
            if($memberEmail == ""){
              $pesan = "Skipping! email is empty!";
            } else if($memberStatus != "Ready"){
              $pesan = "Skipping! status not ready!";
            } else {
              $conn->query("UPDATE mailblastindrstore SET status = 'Failed' WHERE id = '".$memberID."' ");
              $lastMemberID = substr($memberID, -1);
              if($lastMemberID == "1" || $lastMemberID == "6"){
                $relayHost = "mail.indracostore.com";
                $relayUname = "no-reply01@indracostore.com";
                $relayPassword = "(.=)reLaY01s-inrStore_+";
                $relayPort = "465";
                $relaySenderAs = "no-reply@indracostore.com";
                $relaySenderName = "INDRACO Store";
              } else if($lastMemberID == "2" || $lastMemberID == "7"){
                $relayHost = "mail.indracostore.com";
                $relayUname = "no-reply02@indracostore.com";
                $relayPassword = "(.=)reLaY02s-inrStore_+";
                $relayPort = "465";
                $relaySenderAs = "no-reply@indracostore.com";
                $relaySenderName = "INDRACO Store";
              } else if($lastMemberID == "3" || $lastMemberID == "8"){
                $relayHost = "mail.indracostore.com";
                $relayUname = "no-reply03@indracostore.com";
                $relayPassword = "(.=)reLaY03s-inrStore_+";
                $relayPort = "465";
                $relaySenderAs = "no-reply@indracostore.com";
                $relaySenderName = "INDRACO Store";
              } else if($lastMemberID == "4" || $lastMemberID == "9"){
                $relayHost = "mail.indracostore.com";
                $relayUname = "no-reply04@indracostore.com";
                $relayPassword = "(.=)reLaY04s-inrStore_+";
                $relayPort = "465";
                $relaySenderAs = "no-reply@indracostore.com";
                $relaySenderName = "INDRACO Store";
              } else {
                $relayHost = "mail.indracostore.com";
                $relayUname = "no-reply05@indracostore.com";
                $relayPassword = "(.=)reLaY05s-inrStore_+";
                $relayPort = "465";
                $relaySenderAs = "no-reply@indracostore.com";
                $relaySenderName = "INDRACO Store";
              }
              $daJson["sending"]["host"] = $relayHost;
              $daJson["sending"]["relay"] = $relayUname;
              include "content-indracostore.php";
              try{
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host     = $relayHost;
                $mail->SMTPAuth = true;
                $mail->Username = $relayUname;
                $mail->Password = $relayPassword;
                $mail->SMTPSecure = 'ssl';
                $mail->Port     = $relayPort;
                $mail->setFrom($relaySenderAs, $relaySenderName);
                $mail->addAddress($memberEmail, $memberNama);
                //$mail->addBcc('aldy.indraco@gmail.com', 'ok');
                //$mail->addAttachment('./pdfs/'.$filename);
                $mail->isHTML(true);
                $mail->Subject = $contentSubject;
                $mail->Body    = $contentHTML;
                $mail->AltBody = 'Sorry, cannot show this page. Your email client is not supported a HTML format';
                $mail->send();
                $conn->query("UPDATE mailblastindrstore SET status = 'Standby' WHERE id = '".$memberID."' ");
              } catch(e){
                $pesan = "Failed sending email - ".$memberEmail;
              }
              $status = "Success";
              $pesan = "Mail Sended";
            }
          }
        }
      } else {
        $pesan = "Sorry! Unidentified website!";
      }
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
