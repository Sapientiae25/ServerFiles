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

            $sql = "SELECT break_start,break_id FROM breaks WHERE account_fk = ? AND  @startTime > break_start AND
             break_end BETWEEN @startTime and @endTime ORDER BY break_start LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {
                $break_start = strval($row["break_start"]);
                $break_id = strval($row["break_id"]);
                $exists = true;

                $sql = "DELETE FROM breaks WHERE break_id = ?";
                $stmt= $conn->prepare($sql);
                $stmt->bind_param("i", $break_id);
                $stmt->execute();
                echo $break_start;}

            $sql = "SELECT break_end,break_id FROM breaks WHERE account_fk = ? AND @endTime > break_end AND
             break_start BETWEEN @startTime and @endTime  ORDER BY break_end DESC LIMIT 1";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $account_id);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while($row = mysqli_fetch_assoc($result)) {
                $break_end = strval($row["break_end"]);
                $break_id = strval($row["break_id"]);
                $exists = true;

                $sql = "DELETE FROM breaks WHERE break_id = ?";
                $stmt= $conn->prepare($sql);
                $stmt->bind_param("i", $break_id);
                $stmt->execute();
                echo $break_end;}
        }

        $sql = "INSERT INTO breaks (break_start, break_end, account_fk) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $break_start, $break_end, $account_id);
        $stmt->execute();
    }else{echo "failed";}
?>