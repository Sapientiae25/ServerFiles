<?php
    if (isset($_POST['account_id']) && isset($_POST['first_day'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $first_date = $_POST['first_day'];
        $first_datetime = new DateTime($first_date);
        $first_day = $first_datetime->format('d');
    
        $dates = array();
        $breaks = array();
        $return_info = array();
        
        $sql = "SET @startTime = cast(? as DATE)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $first_date);
        $stmt->execute();

        $sql = "SELECT break_start, break_end, break_id,cast(break_start as date) as s_date FROM breaks
            WHERE account_fk = ? AND cast(break_start as date) = @startTime OR
            cast(break_end as date) = @startTime";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        
        
        while($row = mysqli_fetch_assoc($result)) {
            $break = array();
            $span_values = array();
            $start = strval($row["break_start"]);
            $end = strval($row["break_end"]);
            $break_id = strval($row["break_id"]);
            $s_date = strval($row["s_date"]);
            $start_datetime = new DateTime($start);
            $end_datetime = new DateTime($end);
            $start_time_obj = strtotime($start);
            $end_time_obj = strtotime($end);
            $start_time = $start_datetime->format('H:i');
            $end_time = $end_datetime->format('H:i');
            $total_mins = (($end_time_obj - $start_time_obj) / 60);
            $row_count = $total_mins / 15;
            $start_hour = $start_datetime->format('H');
            $start_minute = $start_datetime->format('i');
            $end_minute = $end_datetime->format('i');
            $end_hour = $end_datetime->format('H');
            $current_hour = $start_minute / 15;
            $final_hour = (60 - $end_minute) / 15;
            $hour_difference = ($end_hour - $start_hour - 1);
            if ($hour_difference < 0){$remove_hours = 0;}else{$remove_hours = $hour_difference;} 

            $break += ["date" => $s_date];
            $break += ["position" => $start_hour];
            $break += ["row_count" => $row_count];
            $break += ["start" => $start_time];
            $break += ["end" => $end_time];
            $break += ["remove_hours" => $remove_hours];
            $break += ["first_span" => $current_hour];
            $break += ["final_span" => $final_hour];
            $break += ["id" => $break_id];
            array_push($breaks,$break);
        }

        $sql = "SELECT start, end, st.name,booking_id,style_fk,cast(start as date) as s_date FROM booking
            INNER JOIN style AS st ON st.style_id = style_fk
            WHERE account_fk = ? AND cast(start as date) = @startTime OR
            cast(end as date) = @startTime";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $book = array();
            $start = strval($row["start"]);
            $end = strval($row["end"]);
            $name = strval($row["name"]);
            $booking_id = strval($row["booking_id"]);
            $style_id = strval($row["style_fk"]);
            $start_dt = strval($row["s_date"]);
            $start_time_obj = strtotime($start);
            $end_time_obj = strtotime($end);
            $start_time = $start_datetime->format('H:i');
            $end_time = $end_datetime->format('H:i');
            $total_mins = (($end_time_obj - $start_time_obj) / 60);
            $row_count = $total_mins / 15;
            $start_hour = $start_datetime->format('H');
            $start_minute = $start_datetime->format('i');
            $end_minute = $end_datetime->format('i');
            $end_hour = $end_datetime->format('H');
            $current_hour = $start_minute / 15;
            $final_hour = (60 - $end_minute) / 15;
            $hour_difference = ($end_hour - $start_hour - 1);
            if ($hour_difference < 0){$remove_hours = 0;}else{$remove_hours = $hour_difference;} 

            $book += ["position" => $start_hour];
            $book += ["row_count" => $row_count];
            $book += ["start" => $start_time];
            $book += ["date" => $start_dt];
            $book += ["end" => $end_time];
            $book += ["remove_hours" => $remove_hours];
            $book += ["first_span" => $current_hour];
            $book += ["final_span" => $final_hour];
            $book += ["booking_id" => $booking_id];
            $book += ["style_id" => $style_id];
            array_push($dates,$book);
        }
        $return_info += ["dates" => $dates];
        $return_info += ["break" => $breaks];
        echo json_encode($return_info);
    }else{echo "failed";}
?>