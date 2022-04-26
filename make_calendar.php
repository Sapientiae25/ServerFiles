<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['end'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $open = $_POST['start'];
        $close = $_POST['end'];
    
        $breaks = array();

        // $dt  = new DateTime();
        // $date = $dt->createFromFormat('d/m/Y', $open);
        // $open_date = $date->format('Y-m-d H:i:s');

        // $dt  = new DateTime();
        // $date = $dt->createFromFormat('d/m/Y', $close);
        // $close_date = $date->format('Y-m-d H:i:s');
        
        $sql = "SET @startTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $open);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $close);
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

            $book += ["calendar" => 1];
            $break += ["start" => $start];
            $break += ["end" => $end];
            $book += ["style_id" => 0];
            array_push($breaks,$break);
        }

        $sql = "SELECT (IF(start BETWEEN @startTime and @endTime,time_to_sec(start) DIV 60,null)) AS book_start,style_fk,
                    (IF(end BETWEEN @startTime and @endTime,time_to_sec(end) DIV 60,null)) AS book_end FROM booking
                    WHERE account_fk = ? AND start BETWEEN @startTime and @endTime OR end BETWEEN @startTime and @endTime";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $book = array();
            $start = strval($row["book_start"]);
            $end = strval($row["book_end"]);
            $style_id = strval($row["style_fk"]);

            $book += ["calendar" => 2];
            $book += ["start" => $start];
            $book += ["end" => $end];
            $book += ["style_id" => $style_id];

            array_push($breaks,$book);
        }
        echo json_encode($breaks);
    }else{echo "failed";}
?>