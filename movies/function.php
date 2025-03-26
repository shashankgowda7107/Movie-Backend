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
function storeMovie($storeMovie){
    global $conn;

$movie_name = mysqli_real_escape_string($conn, $storeMovie['movie_name']);
$rel_date = mysqli_real_escape_string($conn, $storeMovie['rel_date']);
$lan_id = mysqli_real_escape_string($conn, $storeMovie['lan_id']);

if(empty(trim($movie_name))){
return error422('enter movie name');

}else if(empty(trim($rel_date))){
    return error422('enter date');

}else if(empty(trim($lan_id))){
    return error422('select language');

}else{
    $query = "insert into movies (movie_name,rel_date,lan_id) values ('$movie_name','$rel_date','$lan_id')";
    $result = mysqli_query($conn, $query);

    if($result){
        $data=[
            'status'=>1, 
            'message'=>'Movie Created Successfully',
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
    
    $query = 'select m.*,l.* from languages l inner join movies m on m.lan_id=l.lan_id';
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

    function getMovie($customerParams) {
        global $conn;
        
        if ($customerParams["lan_id"] == null) {
            return error422('Enter your lan_id');
        }
        
        $customerID = mysqli_real_escape_string($conn, $customerParams["lan_id"]);
        $query = "SELECT movie_id, movie_name FROM movies WHERE lan_id = '$customerID'";
        $res = mysqli_query($conn, $query);
        
        if ($res) {
            if (mysqli_num_rows($res) > 0) { 
                $data = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $data[] = $row;
                }
                $response = [
                    'status' => 200,
                    'message' => 'Movies Found',
                    'data' => $data
                ];
                header("HTTP/1.0 200 OK");
                return json_encode($response);
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'No movies found',
                ];
                header("HTTP/1.0 404 Not Found");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }


    // function getMovie($customerParams){
    //     global $conn;
        
    //     if($customerParams["lan_id"] == null){
    //         return error422('enter your customer id');
    //     }
    //     $customerID=mysqli_real_escape_string($conn, $customerParams["lan_id"]);
    //     $query = "SELECT movie_id,movie_name FROM movies WHERE lan_id = '$customerID'";
    //     $res = mysqli_query($conn, $query);
        
        
    //     if($res){
            
    //     if(mysqli_num_rows($res) >= 0){
    //     $res=mysqli_fetch_assoc($res);
    //     $data=[
    //         'status'=>200,
    //         'message'=>'Customer Found',
    //         'data'=> $res
    //     ];
    //     header("HTTP/1.0 200 OK");
    //     return json_encode($data);
    //     }else{
    //         $data=[
    //             'status'=>404,
    //             'message'=>'no customer found',
    //         ];
    //         header("HTTP/1.0 404 no customer found");
    //         return json_encode($data);
    //     }
    //     }else{
    //         $data=[
    //             'status'=>500,
    //             'message'=>'Internal Server Error',
    //         ];
    //         header("HTTP/1.0 500 Internal Server Error");
    //         return json_encode($data);
    //     }
    //     }

    
?>