<?php
// response function
function hasInternalError($response){

    if (is_null($response) || $response == ""){
        $response = "Data not found";
    }

    header('Content-type: application/json');
    http_response_code(500);
    echo json_encode([
        'message' => $response
    ]);
    exit();
}

function hasSuccess($response){
    header('Content-type: application/json');
    http_response_code(200);
    echo json_encode($response);
    exit();
}
// end;

?>