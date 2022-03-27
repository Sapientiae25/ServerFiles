<?php
    if (isset($_POST['gender'])){
        require_once 'conn.php';

        $gender = $_POST['gender'];
        
        $sql = "SELECT im.image_id FROM filters AS fil
        INNER JOIN style_images as im ON im.style_fk = fil.style_fk
        WHERE fil.gender = ?
        ORDER BY RAND()
        LIMIT 1;";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $gender);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = "";
        
        while($row = mysqli_fetch_assoc($result)) {
            $info = strval($row["image_id"]);}
    
        echo $info;
    }else{echo "failed.";}
?>