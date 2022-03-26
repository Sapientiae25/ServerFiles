<?php
    if (isset($_POST['account_id']) && isset($_POST['image'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $image = $_POST['image'];

        $sql = "INSERT INTO saloon_images (saloon_fk) VALUES (?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        $url = mysqli_insert_id($conn);

        $path = "saloon_images/$url.jpeg";
   
        file_put_contents($path,base64_decode($image));

        echo $url;
        
    }else{echo "failed";}
?>