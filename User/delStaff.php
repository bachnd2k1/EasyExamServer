<?php
    include '../Connect.php';
    include 'Staff.php';

    $response = array();

    

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $MaNV = isset($_POST['MaNV']) ? $_POST['MaNV']: '';
       
        
        if(isset($_POST['MaNV']) ){

            $query = "DELETE FROM nhanvien WHERE MaNV = '$MaNV'";
            if($conn->query($query) == TRUE){
                 $response['message'] = "done";
            }else{
                $response['message'] = "error";
            }
        
        }else{
            $response['error'] = true;
            $response['message'] = "Required fields are missing";
        }

     }else{
        $response['error'] = true;
        $response['message'] = "Invalid Request"; 
     }

     echo json_encode($response);
?>