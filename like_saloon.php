<?php
    if (isset($_POST['user_id']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $account_id = $_POST['account_id'];

        $sql = "SELECT like_id FROM saloon_likes WHERE user_fk = ? AND saloon_fk = ?";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id,$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        if (mysqli_num_rows($result)==0) {
            $sql = "INSERT INTO saloon_likes (user_fk,saloon_fk) VALUES (?,?)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id,$account_id);
            $stmt->execute();}
        else{
            $sql = "DELETE FROM saloon_likes WHERE user_fk = ? AND saloon_fk = ?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id,$account_id);
            $stmt->execute();}
    }else{echo "failed";}
?>