<?php

require '../inc/dbcon.php';

function error422($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit;
}
function storelang($storelang){
    global $conn;

    $lan_name = mysqli_real_escape_string($conn, $storelang['lan_name']);

    if(empty(trim($lan_name))){
        return error422('Enter your name');
    } else {
        $query = "INSERT INTO languages (lan_name) VALUES ('$lan_name')";
        $result = mysqli_query($conn, $query);

        if($result){
            $data=[
                'status'=>1, 
                'message'=>'Language Created Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        } else {
            $data=[
                'status'=>500,
                'message'=>'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function getLanguagesList(){
    global $conn;
    
    $query = 'select * from languages';
    $query_run = mysqli_query($conn, $query);
    
    if($query_run){
    if(mysqli_num_rows($query_run) > 0){
    $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    $data=[
        'status'=>200,
        'message'=>'Customers Found SuccessFully',
        'data'=> $response
    ];
    header("HTTP/1.0 200 OK");
    return json_encode($data);
    }else{
        $data=[
            'status'=>404,
            'message'=>'Customers Not Found',
        ];
        header("HTTP/1.0 404 Customers Not Found");
        return json_encode($data);
    }
    }else{
        $data=[
            'status'=>500,
            'message'=>'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
    }



?>