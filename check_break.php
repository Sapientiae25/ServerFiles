<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['end'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $open = $_POST['start'];
        $close = $_POST['end'];
    
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

        $sql = "SELECT DATE_FORMAT(start, '%H:%i') AS book_start,style_fk,st.name, DATE_FORMAT(end, '%H:%i') AS book_end,us.email
                    FROM booking 
                    INNER JOIN style AS st ON st.style_id = style_fk
                    INNER JOIN user AS us ON us.user_id = user_fk
                    WHERE account_fk = ? AND cancel = 0 AND start BETWEEN @startTime and @endTime OR end BETWEEN @startTime and @endTime";

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
            $email = strval($row["email"]);

            $book += ["email" => $email];
            $book += ["start" => $start];
            $book += ["end" => $end];
            $book += ["style_id" => $style_id];
            $book += ["name" => $name];

            array_push($breaks,$book);
        }

        $infos += ["breaks" => $breaks];
        $infos += ["past" => $past];

        echo json_encode($infos);
    }else{echo "failed";}
?>