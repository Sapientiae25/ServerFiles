<?php
    if (isset($_POST['length'])){
        require_once 'conn.php';

        $length = $_POST['length'];
        
        $sql = "SELECT im.image_id FROM filters AS fil
        LEFT JOIN style_images as im ON im.style_fk = fil.style_fk
        WHERE fil.length = ?
        ORDER BY RAND()
        LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $length);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = "";
        
        while($row = mysqli_fetch_assoc($result)) {
            $info = strval($row["image_id"]);}
    
        echo $info;
    }else{echo "failed.";}
?>