<?php
    if (isset($_POST['url'])){
        require_once 'conn.php';

        $url = $_POST['url'];

        $sql = "DELETE FROM saloon_images WHERE image_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$url);
        $stmt->execute();

        $path = "saloon_images/$url.jpeg";

        if (!unlink($url)) { echo ("Image cannot be deleted due to an error");  } 
        else { echo ("Image has been deleted"); }
    }else{echo "failed";}
?>