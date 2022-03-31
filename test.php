<?php
        require_once 'conn.php';

        $sql = "SELECT like_id FROM style_likes WHERE user_fk = 4  AND style_fk = 24";
        
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 

        echo mysqli_num_rows($result);
?>