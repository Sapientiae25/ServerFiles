<?php
    if (isset($_POST['break_id']) && isset($_POST['break_start']) && isset($_POST['break_end']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $break_id = $_POST['break_id'];
        $break_start = $_POST['break_start'];
        $break_end = $_POST['break_end'];
        $account_id = $_POST['account_id'];
        $exists = true;

        while ($exists){
            $exist = false;

            $sql = "SET @startTime = cast(? as DATETIME)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("s", $start_time);
            $stmt->execute();
    
            $sql = "SET @endTime = cast(? as DATETIME)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("s", $end_time);
            $stmt->execute();

            $sql = "SELECT break_start FROM breaks WHERE (@startTime < break_start AND break_start < @endTime) OR
            (@startTime < break_end AND break_end < @endTime) AND break_start > @startTime ORDER BY break_start LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {$break_start = strval($row["break_start"]); $exist = true;}

            $sql = "SELECT break_end FROM breaks WHERE (@startTime < break_start AND break_start < @endTime) OR
             (@startTime < break_end AND break_end < @endTime) AND break_end > @endTime  ORDER BY break_end DESC LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {$break_end = strval($row["break_end"]); $exist = true;}
        }

        $sql = "UPDATE breaks SET break_start = ?, break_end = ? WHERE break_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $break_start, $break_end, $break_id);
        $stmt->execute();
    }else{echo "failed";}
?>