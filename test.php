<?php
        require_once 'conn.php';

        $style_id = 2;
        $date = "2022-03-14 00:00:00";

        $sql = "SELECT (TIMESTAMPDIFF(HOUR,?, start)) AS diff,start FROM booking WHERE booking_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss",$date,$style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $diff = "";

        while($row = mysqli_fetch_assoc($result)) {
            $diff = strval($row["diff"]);
            echo "\n";
        echo $diff;

        }
?>