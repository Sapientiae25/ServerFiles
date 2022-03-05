<?php
    if (isset($_POST['booking_id'])){
        require_once 'conn.php';

        $booking_id = $_POST['booking_id'];

        $sql = "DELETE FROM booking WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
    }else{echo "failed";}
?>