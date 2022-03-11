<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "INSERT INTO saloon_images (saloon_fk) VALUES (?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        $url = mysqli_insert_id($conn);
        echo $url;
        
    }else{echo "failed";}
?>