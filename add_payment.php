<?php
    if (isset($_POST['number']) && isset($_POST['cvv']) && isset($_POST['expiry']) && isset($_POST['user_id']) 
    && isset($_POST['name'])){
        require_once 'conn.php';

        $number = $_POST['number'];
        $cvv = $_POST['cvv'];
        $expiry = $_POST['expiry'];
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];

        $sql = "INSERT INTO payment (card_number,cvv,expiry,user_fk,name) VALUES (?,?,?,?,?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("sssis", $number,$cvv,$expiry,$user_id,$name);
        $stmt->execute();}
    else{echo "failed";}
?>