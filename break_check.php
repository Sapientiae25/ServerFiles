<?php
    if (isset($_POST['account_id']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['exist_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $exist_id = $_POST['exist_id'];
        $breaks = array();
        $infos = array();

        $sql = "SET @startTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $start_time);
        $stmt->execute();

        $sql = "SET @endTime = cast(? as DATETIME)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $end_time);
        $stmt->execute();

        $sql = "SELECT @startTime < NOW() as past";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 
        while($row = mysqli_fetch_assoc($result)) {$past = strval($row["past"]);}

        $sql = "SELECT start,end,st.name,booking_id FROM booking
        INNER JOIN style AS st ON st.style_id = style_fk
            WHERE account_fk = ? AND style_id != ? AND cast(start as datetime)
            BETWEEN @startTime and @endTime OR cast(end as datetime) BETWEEN @startTime and @endTime";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $account_id,$exist_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $book = array();
            $start = strval($row["start"]);
            $end = strval($row["end"]);
            $name = strval($row["name"]);
            $id = strval($row["booking_id"]);
            $start_dt = new DateTime($start);
            $end_dt = new DateTime($start);
            $startTime = $start_dt->format('H:i');
            $endTime = $end_dt->format('H:i');
            $book += ["type" => 2];
            $book += ["end" => $endTime ];
            $book += ["start" => $startTime];
            $book += ["id" => $id];
            $book += ["style" => $name];
            array_push($breaks,$book);}

        $infos += ["breaks" => $breaks];
        $infos += ["past" => $past];

        echo json_encode($infos);
    }else{echo "failed";}
?>