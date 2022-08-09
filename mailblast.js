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


// Init Variables
var apidir = "api/";
var webnow = "";

function getWebData(){
  webnow = document.getElementById("websiteactive").value;
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=getdata',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus === "Success"){
            var countmailready = resultParse.mailready.length;
            if(countmailready == 0){
              document.getElementById("datafetch").innerHTML = `
              <tr>
                <th style="background-color: rgba(255,255,255,.5); width:50px;"></th>
                <th>Email</th>
                <th>Status</th>
                <th style="background-color: rgba(255,255,255,.5); width:30px;"></th>
              </tr>
              <tr>
                <td colspan=4> No Data</td>
              </tr>
              `;
            } else {
              var pid = 0;
              var tableHTML = `
              <tr>
                <th style="background-color: rgba(255,255,255,.5); width:50px;"></th>
                <th>Email</th>
                <th>Status</th>
                <th style="background-color: rgba(255,255,255,.5); width:30px;"></th>
              </tr>
              `;
              while(pid < countmailready){
                var tableCache = `
                <tr>
                  <td>${pid + 1}</td>
                  <td style="text-align:left;">${resultParse.mailready[pid].email}</td>
                  <td>${resultParse.mailready[pid].status}</td>
                  <td>
                    <button onclick='changeStatus("${resultParse.mailready[pid].id}")' class="control_delete">x</button>
                  </td>
                </tr>
                `;
                tableHTML = tableHTML + tableCache;
                pid++;
              }
              document.getElementById("datafetch").innerHTML = tableHTML;
            }
            showElement();
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
}

function showElement(){
  var navigationcontainer = document.getElementById("navigationcontainer");
  var dashboard = document.getElementById("dashboard");
  navigationcontainer.style.opacity = "1";
  navigationcontainer.style.visibility = "visible";
  navigationcontainer.style.transform = "translateY(0px)";
  dashboard.style.opacity = "1";
  dashboard.style.visibility = "visible";
  dashboard.style.transform = "translateY(0px)";
}

function changeStatus(id){
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else if(id == ""){
    showMsg("Sorry id cannot be empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=rmlist',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow,
          id : id
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus === "Success"){
            document.getElementById("msglogo").innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            `;
            //showMsg(resultMessage);
            getWebData();
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
}

function showFormAdd(){
  var formadd = document.getElementById("formadd");
  var formaddcore = document.getElementById("formaddcore");
  formadd.style.opacity = "1";
  formadd.style.visibility = "visible";
  formaddcore.style.transform = "translateY(0px)";
  getDestination();
}

function closeFormAdd(){
  var formadd = document.getElementById("formadd");
  var formaddcore = document.getElementById("formaddcore");
  formadd.style.opacity = "0";
  formadd.style.visibility = "hidden";
  formaddcore.style.transform = "translateY(-50px)";
  document.getElementById("searchval").value = "";
}

function getDestination(){
  var searchnew = document.getElementById("searchval").value;
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=getdestination',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow,
          search : searchnew
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus == "Success"){
            var countstandby = resultParse.standby.length;
            if(countstandby == 0){
              document.getElementById("tableaddfetch").innerHTML = `
              <tr>
                <td colspan=3>Empty Data</td>
              </tr>
              `;
            } else {
              var standbyHTML = ``;
              var pid = 0;
              while(pid < countstandby){
                var standbyCache = `
                <tr>
                  <td style="width:30px; text-align:right;">${pid + 1}</td>
                  <td style="text-align:left;">${resultParse.standby[pid].email}</td>
                  <td style="width:30px;"><button onclick='addDestination("${resultParse.standby[pid].id}")' class="form_core_table_add">+</button></td>
                </tr>
                `;
                standbyHTML = standbyHTML + standbyCache;
                pid++;
              }
              document.getElementById("tableaddfetch").innerHTML = standbyHTML;
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
}

function addDestination(id){
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else if(id == ""){
    showMsg("Sorry id is empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=adddestination',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow,
          id : id
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus === "Success"){
            document.getElementById("msglogo").innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            `;
            //showMsg(resultMessage);
            getDestination();
            getWebData();
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
}

function setGroup(code){
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else if(code == ""){
    showMsg("Sorry code is empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=setgroup',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow,
          code : code
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus === "Success"){
            document.getElementById("msglogo").innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            `;
            showMsg(resultMessage);
            getWebData();
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
}

function unsetGroup(code){
  if(webnow == ""){
    showMsg("Sorry website is empty!");
  } else if(code == ""){
    showMsg("Sorry code is empty!");
  } else {
    try{
      $.ajax({
        url: apidir + 'api-mailblast.php?do=unsetgroup',
        type: 'POST',
        headers: {
        },
        data : {
          website : webnow,
          code : code
        },
        success: function(result){
          var resultParse = JSON.parse(result);
          var resultStatus = resultParse.status;
          var resultMessage = resultParse.message;
          if(resultStatus === "Success"){
            document.getElementById("msglogo").innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            `;
            showMsg(resultMessage);
            getWebData();
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
}

function openSure(){
  var msgcontainersure = document.getElementById("msgcontainersure");
  var msgcoresure = document.getElementById("msgcoresure");
  msgcontainersure.style.opacity = "1";
  msgcontainersure.style.visibility = "visible";
  msgcoresure.style.transform = "translateY(0px)";
}

function closeSure(){
  var msgcontainersure = document.getElementById("msgcontainersure");
  var msgcoresure = document.getElementById("msgcoresure");
  msgcontainersure.style.opacity = "0";
  msgcontainersure.style.visibility = "hidden";
  msgcoresure.style.transform = "translateY(-50px)";
}

function beginBlast(){
  if(webnow == ""){
    showMsg("Web not selected!");
  } else {
    if(webnow == "Supresso ID"){
      window.location.href = "blast/supressoid/";
    } else if(webnow == "Supresso SG"){
      window.location.href = "blast/supressosg/";
    } else if(webnow == "Pandangarden"){
      window.location.href = "blast/pandangarden/";
    } else if(webnow == "Indracostore"){
      window.location.href = "blast/indracostore/";
    } else {
      showMsg("Unable to blast! Unidentified website!");
    }
  }
}
