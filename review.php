<?php
    if (isset($_POST['review']) && isset($_POST['rating']) && isset($_POST['style_id']) && isset($_POST['user_id'])){
        require_once 'conn.php';

        $review = $_POST['review'];
        $rating = $_POST['rating'];
        $style_id = $_POST['style_id'];
        $user_id = $_POST['user_id'];

        $sql = "INSERT INTO reviews (style_fk,review,rating,user_fk,time) VALUES(?,?,?,?,NOW())";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ssss",$style_id,$review,$rating,$user_id);
        $stmt->execute();
    }else{echo "failed";}
?>