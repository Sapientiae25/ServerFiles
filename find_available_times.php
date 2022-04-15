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

        $sql = "SELECT time_to_sec(break_start) DIV 60 AS break_start, time_to_sec(break_end) DIV 60 AS break_end FROM breaks
            WHERE account_fk = ? AND cast(break_start as date) BETWEEN @startTime and @endTime OR cast(break_end as date)
             BETWEEN @startTime and @endTime";

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

        $sql = "SELECT time_to_sec(start) DIV 60 AS book_start, time_to_sec(end) DIV 60 AS book_end FROM booking
            INNER JOIN style AS st ON st.style_id = style_fk
            WHERE account_fk = ? AND cast(start as date) = @startTime OR
            cast(end as date) = @startTime";

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
            array_push($dates,$book);
        }
        $return_info += ["dates" => $dates];
        $return_info += ["break" => $breaks];
        echo json_encode($return_info);
    }else{echo "failed";}
?>