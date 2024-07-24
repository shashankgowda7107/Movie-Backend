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
function storeReview($storeMovie){
    global $conn;

$reviews = mysqli_real_escape_string($conn, $storeMovie['reviews']);
$review_date = mysqli_real_escape_string($conn, $storeMovie['review_date']);
$movie_id = mysqli_real_escape_string($conn, $storeMovie['movie_id']);

if(empty(trim($reviews))){
return error422('enter movie name');

}else if(empty(trim($review_date))){
    return error422('enter date');

}else if(empty(trim($movie_id))){
    return error422('select language');

}else{
    $query = "insert into reviews (reviews,review_date,movie_id) values ('$reviews','$review_date','$movie_id')";
    $result = mysqli_query($conn, $query);

    if($result){
        $data=[
            'status'=>1, 
            'message'=>'Review Submitted Successfully',
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





?>