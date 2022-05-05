<?php
        require_once 'conn.php';

        $account_id = 10;
        $open = "2022/05/06 05:00";
        $close = "2022/05/06 06:30";
        $breaks = array();
        $infos = array();

        $sql = "SET @startTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $open);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $close);
        $stmt->execute();

        $sql = "SELECT @startTime < NOW() as past";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 
        while($row = mysqli_fetch_assoc($result)) {$past = intval($row["past"]);}

        $sql = "SELECT DATE_FORMAT(start, '%H:%i') AS book_start,style_fk,st.name, DATE_FORMAT(end, '%H:%i') AS book_end FROM booking
                    INNER JOIN style AS st ON st.style_id = style_fk
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
            $name = strval($row["name"]);

            $book += ["start" => $start];
            $book += ["end" => $end];
            $book += ["style_id" => $style_id];
            $book += ["name" => $name];

            array_push($breaks,$book);
        }

        $infos += ["breaks" => $breaks];
        $infos += ["past" => $past];

        echo json_encode($infos);
?>