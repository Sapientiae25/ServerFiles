<?php
    if (isset($_POST['date']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $date = $_POST['date'];
        $account_id = $_POST['account_id'];

        $sql = "SELECT HOUR(start) as s_hour, MINUTE(start) as s_min, HOUR(end) as e_hour, MINUTE(end) as e_min 
        FROM booking WHERE account_fk = ? AND ? BETWEEN cast(start as date) and cast(end as date)";
               
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("is", $account_id,$date);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $s_hour = strval($row["s_hour"]);
            $s_min = strval($row["s_min"]);
            $e_hour = strval($row["e_hour"]);
            $e_min = strval($row["e_min"]);
    
            $info += ["s_hour" => $s_hour];
            $info += ["s_min" => $s_min];
            $info += ["e_hour" => $e_hour];
            $info += ["e_min" => $e_min];

            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>