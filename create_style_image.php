<?php
    if (isset($_POST['style_id']) && isset($_POST['image'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];
        $image = $_POST['image'];


        $sql = "INSERT INTO style_images (style_fk) VALUES (?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        $url = mysqli_insert_id($conn);

        $path = "style_images/$url.jpeg";
   
        file_put_contents($path,base64_decode($image));

        echo $url;
        
    }else{echo "failed";}
?>