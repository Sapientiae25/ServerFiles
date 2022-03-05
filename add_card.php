<?php
    if (isset($_POST['number']) && isset($_POST['cvv']) && isset($_POST['expiry']) && isset($_POST['user_id'])){
        require_once 'conn.php';

        $number = $_POST['number'];
        $cvv = $_POST['cvv'];
        $expiry = $_POST['expiry'];
        $user_id = $_POST['user_id'];

        $sql = "INSERT INTO payment (number,cvv,expiry,user_fk) VALUES (?,?,?,?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("sssi", $number,$cvv,$expiry,$user_id);
        $stmt->execute();}
    else{echo "failed";}
?>