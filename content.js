const apidir = "content/";
let pathPreview = "";

function searchBrand(){
    // console.log("access");
    $.ajax({
        url: apidir + 'api-content.php?do=brand',
        type: 'GET',
        headers: {
        },
        success: function(result){
          const res = JSON.parse(result);
          let str = "";
          let n = 1;
          $.each(res, function(i, item){
            str += '<tr style="vertical-align:middle">' +
                    '<td>' + n + '</td>'+
                    '<td>' + item.name + '</td>'+
                    '<td align="center">' + 0 + '</td>'+
                    '<td align="center">' + 0 + '</td>'+
                    '<td align="center"><a href="content-detail.php?slug='+item.slug+'" class="btn btn-sm btn-light"><i class="bi bi-pencil-square"></i></a></td>'+
                    '</tr>';
                    n++;
          });

          $(".body-brand").html(str);

        },
        error: function(error){
            console.log(error);
        }
      });
}

function toDetail(slug){

    $.ajax({
        url: apidir + 'api-content.php?do=load-detail',
        type: 'POST',
        headers: {
        },
        data : {
            "slug" : slug
        },
        success: function(result){
          const res = JSON.parse(result);
        //   console.log(res);
          let str = "";
          str += "<h3 style='color:lightgrey;'>"+res.name+"</h3>";
          str += "<h5 style='color:darkgrey;'>"+res.domain+"</h3>";
          str += "<p style='color:darkgrey;'>folder : "+res.aseet_namespace+"</p>";
          $(".panel-brand").html(str);
        },
        error: function(error){
            console.log(error);
        }
    });
}

function loadContent(slug){
    $.ajax({
        url: apidir + 'api-content.php?do=load-content',
        type: 'POST',
        headers: {
        },
        data : {
            "slug" : slug
        },
        success: function(result){
            const res = JSON.parse(result);
            let str = "";
            let n = 1;
            $.each(res, function(i, item){
              str += '<tr style="vertical-align:middle">' +
                      '<td>' + n + '</td>'+
                      '<td style="color:#ffbe85;"><span style="color:white;">\\</span> ' + item.date +' <span style="color:white;">\\</span> ' + item.time + '</td>'+
                      '<td align="center">' + item.updatedat + '</td>'+
                      '<td align="center">' + item.updatedwho + '</td>'+
                      '<td align="center"><button class="btn btn-sm btn-light" onclick="showEdit(\''+item.id+'\')"><i class="bi bi-pencil-square"></i></button></td>'+
                      '</tr>';
                      n++;
            });
            $(".body-content").html(str);
        },
        error: function(error){
            console.log(error);
        }
    });
}

function showEdit(id){
    $("#modal-edit").modal('show');
    editor.getDoc().setValue("");
    $("#asset-panel").html("")
    $("#id-content").val(id);
    pathPreview = "";
    
    $.ajax({
        url: apidir + 'api-content.php?do=load-content-by-id',
        type: 'POST',
        headers: {
        },
        data : {
            "id" : id
        },
        success: function(result){
            const res = JSON.parse(result);
            
            editor.getDoc().setValue(res.content);

            let str = "";
            if (res.asset.length > 0){
                $.each(res.asset, function(i,item){
                    str += '<div style="border-radius:5px;height:100px;margin-top:10px;text-align:center;cursor:pointer;background-color:grey;"' +
                    'onclick="navigator.clipboard.writeText(\'http://'+item+'\');alert(\'Path Copied!\');">'+
                            '<img src="http://'+item+'" style="height:100%;margin:auto 0px">'+
                            '<div/>';
                });
            }

            // console.log(res.asset);

            pathPreview = res.path;
            $("#asset-panel").html(str);
        },
        error: function(error){
            console.log(error);
        }
    });
}

$("#btn-create").on('click', function(){
    $("#modal-create").modal('show');
})

$("#btn-save-content").on('click', function(){

    const contentbody = editor.getDoc().getValue();
    const id = $("#id-content").val();
    
    $.ajax({
        url: apidir + 'api-content.php?do=update-content',
        type: 'POST',
        headers: {
        },
        data : {
            "id" : id,
            "content" : contentbody
        },
        success: function(result){
            const res = JSON.parse(result);
            console.log(res);
            alert(res.message);
            // if (res.status == "success"){
            //     alert("Saved !");
            // } else {
            //     alert(result);
            // }
        },
        error: function(error){
            console.log(error);
        }
    });
})

$("#btn-preview").on('click', function(){
    window.open(pathPreview);
})

let base64Files = '';
$("#files").on('change', function(e){

    // Get a reference to the file
    const file = e.target.files[0];

    // Encode the file using the FileReader API
    const reader = new FileReader();
    reader.onloadend = () => {
        // console.log(reader.result);
        base64Files = reader.result;
        // Logs data:<type>;base64,wL2dvYWwgbW9yZ...
        
    };
    reader.readAsDataURL(file);
})

function getFileName(fullPath){
    var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
    var filename = fullPath.substring(startIndex);
    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
        return filename = filename.substring(1);
    }
    return "";
}

function loadPanelAsset(){
    const id  = $("#id-content").val();
    $.ajax({
        url: apidir + 'api-content.php?do=load-content-by-id',
        type: 'POST',
        headers: {
        },
        data : {
            "id" : id
        },
        success: function(result){
            const res = JSON.parse(result);
        
            let str = "";
            if (res.asset.length > 0){
                $.each(res.asset, function(i,item){
                    str += '<div style="border-radius:5px;height:100px;margin-top:10px;text-align:center;cursor:pointer;background-color:grey;"' +
                    'onclick="navigator.clipboard.writeText(\'http://'+item+'\');alert(\'Path Copied!\');">'+
                            '<img src="http://'+item+'" style="height:100%;margin:auto 0px">'+
                            '<div/>';
                });
            }
            $("#asset-panel").html(str);
        },
        error: function(error){
            console.log(error);
        }
    });
}

$("#btn-upload").on('click', function(){

    const id            = $("#id-content").val();
    const filePath      = $("#files").val();
    const filename      = getFileName(filePath);
    const type          = filename.split('.').pop();
    const ltype         = type.toLowerCase();
    const isValidType   = ltype == "png" || ltype == "jpg" || ltype == "gif";
    
    if (!isValidType){
        alert(filename + ' - Not Valid Type');
        return;
    }

    $.ajax({
        url: apidir + 'api-content.php?do=upload-asset',
        type: 'POST',
        headers: {
        },
        data : {
            "id" : id,
            "strimg" : base64Files,
            "type" : type
        },
        success: function(result){
            const res = JSON.parse(result);
            if (res.status == "success"){
                loadPanelAsset();
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

function getBase64(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = error => reject(error);
    });
  }



$(".btn-close-edit").on('click', function(){
    
    const modalEdit = $("#modal-edit");
    modalEdit.modal("hide");

    // if(confirm("Do you want to quit edit ?")){
    //     if(confirm("This data maybe not saved yet, are you sure ?")){
    //         modalEdit.modal("hide");
    //     } else {
    //         return false;
    //     }
    // } else {
    //     return false;
    // }
})




