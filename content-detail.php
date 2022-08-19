<!DOCTYPE html>
<html>
  <head>
    <title>Mailblast v.0.0 | Indraco</title>
    <link rel="icon" href="assets/mail.svg" type="image/svg+xml">
    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="mailblast.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/codemirror/lib/codemirror.css">
    <!-- theme codemirror here -->
    <link rel="stylesheet" href="assets/codemirror/theme/ambiance.css">
    <!-- end -->
    <script src="assets/js/bootstrap.min.js"></script>    
    <script src="assets/codemirror/lib/codemirror.js"></script>
    <script src="assets/codemirror/mode/xml/xml.js"></script>
    <script src="assets/codemirror/addon/edit/matchbrackets.js"></script>

    <style>
      body{
        margin:0px;
        background-color: #3D3C42;
        color: white;
        font-family: arial;
      }
    </style>

   
  </head>
  <body>
    <div class="header">
      <object style="float:left; margin-left:20px; margin-top:10px;" width="20px" height="20px" data="assets/mail.svg" type="image/svg+xml"></object>
      <div class="header_appname app_name">
        Indraco Mailblast
      </div>
      <div class="header_appname" style="float:right;">
        [Prototype ver]
      </div>
    </div>

    <div class="container">
      <br/>
      <br/>
      <br/>
      <h3><a href="content.html" style="text-decoration:none;color:white">Content Management</a> / Details</h3>
      <div style="width:100%;text-align:right">
        <button class="btn btn-sm btn-light"><i class="bi bi-plus-lg"></i> Add Content</button>
      </div>
      <br/>

      <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="panel-content panel-brand" style="padding:20px;width:100%;height: max-content;background-color: gray;border-radius: 10px;margin-bottom:20px">
               
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="panel-content" style="padding:20px;width:100%;background-color: gray;border-radius: 10px;max-height:500px;overflow-y:scroll;">
                <table class="table table-striped">
                <thead>
                    <tr style="border-bottom: solid 1px black;">
                    <td>#</td>
                    <td>Content</td>
                    <td align="center">Last Updated</td>
                    <td align="center">Update Who</td>
                    <td align="center">Action</td>
                    </tr>
                </thead>
                <tbody class="body-content">
                    
                </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
      
  <!-- Modal -->
  <div class="modal fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel" style="color:black">Edit Content</h5>
          <button type="button" class="btn-close btn-close-edit" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="color:black">
        <input type="hidden" id="id-content"/>
          <div class="row">
            <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
              <button class="btn btn-sm btn-danger" style="width:100%;"><i class="bi bi-box-arrow-up-right"></i> Preview</button>
              <hr style="color:black">
              <div style="margin-bottom:7px;">Upload File :</div>
                <input type="file" name="" id="" style="margin-bottom:7px;">
                <button class="btn btn-sm btn-primary" style="width:100%;"><i class="bi bi-arrow-bar-up"></i> Upload</button>
                <hr>
                <div style="width:100%;height:500px;background-color:lightgrey;border-radius:5px;overflow-y:scroll;padding:5px;" id="asset-panel">

                </div>
            </div>
            <div class="col-md-8 col-xs-12">
              <form action="">
                <textarea name="" id="content-editor" style="width:100%;">
                </textarea>
              </form>
         
             
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btn-save-content"><i class="bi bi-check-lg"></i> Save</button>
        </div>
      </div>
    </div>
  </div>

  </body>
  <script>
    var textArea = document.getElementById("content-editor");
    var editor = CodeMirror.fromTextArea(textArea, {
      lineNumbers: true,
      mode: "xml",
      htmlMode:true,
      matchBrackets: true,
      theme:"ambiance"
    });
    editor.setSize(null, 800);
  </script>
  <script src="assets/jquery.js" type="text/javascript"></script>
  <script src="content.js" type="text/javascript"></script>
  <script>
    // get slug in url
    const slug = '<?= $_GET["slug"] ?>';
    toDetail(slug);
    loadContent(slug);
  </script>
</html>
