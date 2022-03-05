<?php
    if (isset($_POST['user_id']) && isset($_POST['style_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $style_id = $_POST['style_id'];

        $sql = "SELECT like_id FROM style_likes WHERE user_fk = ?  AND style_fk = ?";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id,$style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        if (mysqli_num_rows($result)==0) {
            $sql = "INSERT INTO style_likes (user_fk,style_fk) VALUES (?,?)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id,$style_id);
            $stmt->execute();}
        else{
            $sql = "DELETE FROM style_likes WHERE user_fk = ? AND style_fk = ?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id,$style_id);
            $stmt->execute();}
    }else{echo "failed";}
?>