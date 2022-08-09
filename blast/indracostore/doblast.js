function showMsg(msg){
  var msgcontainer = document.getElementById("msgcontainer");
  var msgcore = document.getElementById("msgcore");
  var msgcontent = document.getElementById("msgcontent");
  msgcontent.innerHTML = "Sorry! There was an error!";
  if(msg != ""){
    msgcontent.innerHTML = msg;
  }
  msgcontainer.style.opacity = "1";
  msgcontainer.style.visibility = "visible";
  msgcore.style.transform = "translateY(0px)";
}

function closeMsg(){
  var msgcontainer = document.getElementById("msgcontainer");
  var msgcore = document.getElementById("msgcore");
  var msglogo = document.getElementById("msglogo");
  var msgcontent = document.getElementById("msgcontent");
  msgcontainer.style.opacity = "0";
  msgcontainer.style.visibility = "hidden";
  msgcore.style.transform = "translateY(-50px)";
  setTimeout(function(){
    msglogo.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    `;
    msgcontent.innerHTML = "Sorry! There was an error!";
  }, 500);
}

//Init Website
var apidir = "../../api/";
var website = "Indracostore";

var targetid = "";
var targetemail = "";
var targetname = "";
var targethost = "";
var targetrelay = "";
var targetstatus = "";

//Begin Data
checkData();
function checkData(){
  try{
    $.ajax({
      url: apidir + 'api-serv.php?do=getisset',
      type: 'POST',
      headers: {
      },
      data : {
        website : website
      },
      success: function(result){
        var resultParse = JSON.parse(result);
        var resultStatus = resultParse.status;
        var resultMessage = resultParse.message;
        if(resultStatus === "Success"){
          clearView();
          var countdata = resultParse.ready.length;
          if(countdata == 0){
            window.location.href = "success.html";
          } else {
            targetid = resultParse.ready[0].id;
            targetemail = resultParse.ready[0].email;
            targetname = resultParse.ready[0].name;
            targetstatus = resultParse.ready[0].status;
            document.getElementById("statusemail").innerHTML = targetemail;
            document.getElementById("statusname").innerHTML = targetname;
            document.getElementById("statusstat").innerHTML = targetstatus;
            doSend();
          }
        } else {
          showMsg(resultMessage);
        }
      },
      error: function(error){
          console.log(error);
      }
    });
  } catch(e){
    console.log(e);
  }
}

function clearView(){
  document.getElementById("statusemail").innerHTML = "Loading...";
  document.getElementById("statusname").innerHTML = "Loading...";
  document.getElementById("statushost").innerHTML = "Loading...";
  document.getElementById("statusrelay").innerHTML = "Loading...";
  document.getElementById("statusstat").innerHTML = "Loading...";
}

function doSend(){
  try{
    $.ajax({
      url: apidir + 'api-send.php?do=send',
      type: 'POST',
      headers: {
      },
      data : {
        website : website,
        id : targetid
      },
      success: function(result){
        var resultParse = JSON.parse(result);
        var resultStatus = resultParse.status;
        var resultMessage = resultParse.message;
        if(resultStatus === "Success"){
          targethost = resultParse.sending.host;
          targetrelay = resultParse.sending.relay;
          document.getElementById("statushost").innerHTML = targethost;
          document.getElementById("statusrelay").innerHTML = targetrelay;
          setTimeout(function(){
            checkData();
          }, 3000);
        } else {
          document.getElementById("statusstat").innerHTML = "Error API!";
          console.log(resultMessage);
          setTimeout(function(){
            checkData();
          }, 3000);
        }
      },
      error: function(error){
          console.log(error);
      }
    });
  } catch(e){
    console.log(e);
  }
}
