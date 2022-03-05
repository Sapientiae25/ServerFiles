<?php
    if (isset($_POST['account_id']) && isset($_POST['break_start']) && isset($_POST['break_end'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $break_start = $_POST['break_start'];
        $break_end = $_POST['break_end'];
        $exists = true;

        while ($exists){
            $exists = false;

            $sql = "SET @startTime = cast(? as DATETIME)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("s", $start_time);
            $stmt->execute();
    
            $sql = "SET @endTime = cast(? as DATETIME)";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("s", $end_time);
            $stmt->execute();

            $sql = "SELECT break_start FROM breaks WHERE account_fk = ? AND (@startTime < break_start and break_start < @endTime) OR
            (@startTime < break_end and break_end < @endTime) AND break_start > @startTime ORDER BY break_start LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {$break_start = strval($row["break_start"]); $exists = true; echo $break_start;}

            $sql = "SELECT break_end FROM breaks WHERE account_fk = ? AND (@startTime < break_start and break_start < @endTime) OR
             (@startTime < break_end and break_end < @endTime) AND break_end > @endTime  ORDER BY break_end DESC LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {$break_end = strval($row["break_end"]); $exists = true; echo $break_end;}
        }

        

        $sql = "INSERT INTO breaks (break_start, break_end, account_fk) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $break_start, $break_end, $account_id);
        $stmt->execute();
    }else{echo "failed";}
?>