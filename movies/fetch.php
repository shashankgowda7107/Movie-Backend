<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,Authorization,x-Request-with');

include('function.php');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "GET"){
    if(isset($_GET['lan_id'])){
        $customer=getMovie($_GET);
        echo $customer;
    }else{
        $customerList = getLanguagesList();
        echo $customerList;
    }

}
else{
    $data=[
        'status'=>405,
        'message'=>$requestMethod.'Methos Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>