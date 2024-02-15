<?php
    include '../Connect.php';

    $response = array();

    if($_SERVER['REQUEST_METHOD']=='POST'){

    $txtSearch = isset($_POST['txtSearch'])?$_POST['txtSearch']:'';
    if ($txtSearch=='') {
        $sql = "SELECT * from nhanvien";
    } else {
        $sql = "SELECT * from nhanvien where MaNV or TenNV like '%$txtSearch%'";
    }
    $result = $conn->query($sql);
    }
    else{
        $response['error'] = true;
        $response['message'] = "Invalid Request"; 
    }
    echo json_encode($response);
?>