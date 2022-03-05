<?php
    if (isset($_POST['user_id']) && isset($_POST['name'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $name = $_POST['name'];

        $sql = "UPDATE users SET name = ? WHERE user_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss",$name,$user_id);
        $stmt->execute();}
    else{echo "failed"}
?>