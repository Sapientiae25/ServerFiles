<?php
    if (isset($_POST['booking_id']) && isset($_POST['reason'])){
        require_once 'conn.php';

        $booking_id = $_POST['booking_id'];
        $reason = $_POST['reason'];

        $sql = "UPDATE booking SET cancel = 1 AND viewed = 1 WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();

        $sql = "INSERT INTO cancelled (booking_fk,reason,time) VALUES (?,?,now())";
                        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("iisi", $booking_id,$reason);
        $stmt->execute();
    }else{echo "failed";}
?>