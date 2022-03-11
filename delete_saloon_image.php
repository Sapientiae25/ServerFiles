<?php
    if (isset($_POST['url'])){
        require_once 'conn.php';

        $url = $_POST['url'];

        $sql = "DELETE FROM saloon_images WHERE image_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$url);
        $stmt->execute();
    }else{echo "failed";}
?>