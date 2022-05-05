<?php
    if (isset($_POST['booking_id']) && isset($_POST['date'])){ 
        require_once 'conn.php';

        $booking_id = $_POST['booking_id'];
        $date = $_POST['date'];

        $sql = "SELECT (TIMESTAMPDIFF(HOUR,?, start)) AS diff,start FROM booking WHERE booking_id = ? AND cancel = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss",$date,$booking_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $diff = "";

        while($row = mysqli_fetch_assoc($result)) { $diff = strval($row["diff"]);}

        echo $diff;
    }else{echo "failed";}
?>