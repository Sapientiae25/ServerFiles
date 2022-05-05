<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['end'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $open = $_POST['start'];
        $close = $_POST['end'];
    
        $dates = array();
        $breaks = array();
        $return_info = array();

        $dt  = new DateTime();
        $date = $dt->createFromFormat('d/m/Y H:i', $open);
        $open_date = $date->format('Y-m-d H:i:s');

        $dt  = new DateTime();
        $date = $dt->createFromFormat('d/m/Y H:i', $close);
        $close_date = $date->format('Y-m-d H:i:s');
        
        $sql = "SET @startTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $open_date);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $close_date);
        $stmt->execute();

        $sql = "SELECT (IF(break_start BETWEEN @startTime and @endTime,time_to_sec(break_start) DIV 60,null)) as break_start,
            (IF(break_end BETWEEN @startTime and @endTime,time_to_sec(break_end) DIV 60,null)) AS break_end FROM breaks
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

        $sql = "SELECT (IF(start BETWEEN @startTime and @endTime,time_to_sec(start) DIV 60,null)) AS book_start,
                    (IF(end BETWEEN @startTime and @endTime,time_to_sec(end) DIV 60,null)) AS book_end FROM booking
                    WHERE account_fk = ? AND cancel = 0 AND start BETWEEN @startTime and @endTime OR end BETWEEN @startTime and @endTime";

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