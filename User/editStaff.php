<?php
    include '../Connect.php';
    include 'Staff.php';

    $response = array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $MaNV = isset($_POST['MaNV']) ? $_POST['MaNV']: '';
        $TenNV = isset($_POST['TenNV']) ? $_POST['TenNV']: '';
        $NgaySinh = isset($_POST['NgaySinh']) ? $_POST['NgaySinh']: '';
        $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi']: '';
        $GioiTinh = isset($_POST['GioiTinh']) ? $_POST['GioiTinh']: '';
        $Phone = isset($_POST['Phone']) ? $_POST['Phone']: '';
        $Email = isset($_POST['Email']) ? $_POST['Email']: '';
        $SoCMND = isset($_POST['SoCMND']) ? $_POST['SoCMND']: '';
        $SoTk = isset($_POST['SoTk']) ? $_POST['SoTk']: '';
       // $MaPB = isset($_POST['MaPB']) ? $_POST['MaPB']: '';
        $MucLuong = isset($_POST['MucLuong']) ? $_POST['MucLuong']: '';
    
        
        if(isset($_POST['MaNV']) && isset($_POST['TenNV']) && isset($_POST['NgaySinh']) && isset($_POST['DiaChi']) && isset($_POST['GioiTinh'])&& isset($_POST['Phone'])
        && isset($_POST['Email'])&& isset($_POST['SoCMND'])&& isset($_POST['SoTk'])&& isset($_POST['MaPB'])&& isset($_POST['MucLuong'])){

            $query = "UPDATE nhanvien SET TenNV = '$TenNV', NgaySinh = '$NgaySinh', DiaChi = '$DiaChi', GioiTinh = '$GioiTinh', Phone ='$Phone', Email = '$Email', SoCMND = '$SoCMND', SoTk = '$SoTk',
                        MucLuong = '$MucLuong' WHERE MaNV = '$MaNV'";
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