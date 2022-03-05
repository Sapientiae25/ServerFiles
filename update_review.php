<?php
    if (isset($_POST['review']) && isset($_POST['rating']) && isset($_POST['name']) && isset($_POST['style_id'])
    && isset($_POST['user_id'])){
        require_once 'conn.php';

        $review = $_POST['review'];
        $rating = $_POST['rating'];
        $style_id = $_POST['style_id'];
        $user_id = $_POST['user_id'];

        $sql = "UPDATE reviews SET review = ?, rating = ? WHERE style_fk = ? AND user_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ssss",$review,$rating,$style_id,$user_id);
        $stmt->execute();
    }else{echo "failed";}
?>