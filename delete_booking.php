<?php
    if (isset($_POST['booking_id']) && isset($_POST['reason']) && isset($_POST['account_id'])){
        require_once 'conn.php';
        
        $booking_id = $_POST['booking_id'];
        $reason = $_POST['reason'];
        $account_id = $_POST['account_id'];

        $sql = "UPDATE booking SET cancel = 1 AND viewed = 1 WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();

        $sql = "INSERT INTO cancelled (booking_fk,reason,account_fk,time,viewed) VALUES (?,?,?,now(),0)";
                        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("isi", $booking_id,$reason,$account_id);
        $stmt->execute();
        echo $reason;
    }else{echo "failed";}
?>