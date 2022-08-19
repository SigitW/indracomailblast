const apidir = "content/";

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
                    str += '<div style="border:solid 1px grey;border-radius:5px;height:100px;margin-bottom:7px;text-align:center;cursor:pointer;"' +
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
            console.log(result);
            if (result == "success"){
                alert("Saved !");
            } else {
                alert(result);
            }
        },
        error: function(error){
            console.log(error);
        }
    });
})

$(".btn-close-edit").on('click', function(){
    const modalEdit = $("#modal-edit");
    if(confirm("Do you want to quit edit ?")){
        if(confirm("This data maybe not saved yet, are you sure ?")){
            modalEdit.modal("hide");
        } else {
            return false;
        }
    } else {
        return false;
    }
})

