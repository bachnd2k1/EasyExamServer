<?php
    include '../Connect.php';
    include 'Test.php';


    $response = array();
    $query = "SELECT * FROM test";
    $data = mysqli_query($conn, $query);

       while ($row = mysqli_fetch_assoc($data)){
        array_push($response, new Test(
            $row['id'], 
            $row['name'], 
            $row['createDate'], 
            $row['idCreate']
        ));
       }

    echo json_encode($response);
?>