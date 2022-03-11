<?php
    if (isset($_POST['user_id']) && isset($_POST['email']) && isset($_POST['number'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $email = $_POST['email'];
        $number = $_POST['number'];

        $sql = "UPDATE users SET number = ? and email = ? WHERE user_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("sss",$number,$email,$user_id);
        $stmt->execute();}
    else{echo "failed";}
?>