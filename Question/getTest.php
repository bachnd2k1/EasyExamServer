<?php
    include '../Connect.php';
    include 'Test.php';

    $response = array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $idCreate = isset($_POST['idCreate']) ? $_POST['idCreate']: '';
        if(isset($_POST['idCreate'])){
            $query = "SELECT * FROM test where";
            $data = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($data)){
            array_push($response, new Test(
                $row['id'], 
                $row['name'], 
                $row['createDate'],
                $row['idCreate']
            ));
            }
            if($conn->query($query) == TRUE){
               $response['message'] = "done";
            }   else{
              $response['message'] = "error";
            }
        } else{
          $response['error'] = true;
          $response['message'] = "Required fields are missing";
        }
    } else{
      $response['error'] = true;
      $response['message'] = "Invalid Request"; 
   }
    echo json_encode($response);
?>


