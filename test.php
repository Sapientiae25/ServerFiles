<?php
        require_once 'conn.php';

        $account_id = 10;
        $open = "2022/04/26 00:00";
        $close = "2022/04/26 23:59";
    
        $breaks = array();
    
        
        $sql = "SET @startTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $open);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $close);
        $stmt->execute();

        $sql = "SELECT (IF(start BETWEEN @startTime and @endTime,time_to_sec(start) DIV 60,null)) AS book_start,
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

        $book += ["calendar" => 2];
        $book += ["start" => $start];
        $book += ["end" => $end];
        array_push($breaks,$book);
        }
        echo json_encode($breaks);
?>