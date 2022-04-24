<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['end'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $open = $_POST['start'];
        $close = $_POST['end'];
    
        $dates = array();
        $breaks = array();
        $return_info = array();
        
        $sql = "SET @startTime = cast(? as DATE)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $open);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATE)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $close);
        $stmt->execute();

        $sql = "SELECT (IF(break_start BETWEEN @startTime and @endTime,time_to_sec(break_start) DIV 60,null)),
            (IF(break_end BETWEEN @startTime and @endTime,time_to_sec(break_end) DIV 60,null)) AS book_end FROM breaks
            WHERE account_fk = ? AND break_start BETWEEN @startTime and @endTime OR break_end BETWEEN @startTime and @endTime;";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        
        
        while($row = mysqli_fetch_assoc($result)) {
            $break = array();
            $span_values = array();
            $start = strval($row["break_start"]);
            $end = strval($row["break_end"]);

            $break += ["start" => $start];
            $break += ["end" => $end];
            array_push($breaks,$break);
        }

        $sql = "SELECT (IF(start BETWEEN @startTime and @endTime,time_to_sec(start) DIV 60,null)),
                    (IF(end BETWEEN @startTime and @endTime,time_to_sec(end) DIV 60,null)) AS book_end FROM booking
                    WHERE account_fk = ? AND start BETWEEN @startTime and @endTime OR end BETWEEN @startTime and @endTime;";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $book = array();
            $start = strval($row["book_start"]);
            $end = strval($row["book_end"]);

            $book += ["start" => $start];
            $book += ["end" => $end];
            array_push($breaks,$book);
        }
        echo json_encode($breaks);
    }else{echo "failed";}
?>