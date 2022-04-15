<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT HOUR(open) as s_hour, MINUTE(open) as s_min, HOUR(close) as e_hour, MINUTE(close) as e_min 
        FROM account WHERE account_id = ?";
               
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();

        while($row = mysqli_fetch_assoc($result)) {
            $s_hour = strval($row["s_hour"]);
            $s_min = strval($row["s_min"]);
            $e_hour = strval($row["e_hour"]);
            $e_min = strval($row["e_min"]);
    
            $info += ["s_hour" => $s_hour];
            $info += ["s_min" => $s_min];
            $info += ["e_hour" => $e_hour];
            $info += ["e_min" => $e_min];

        }
        echo json_encode($info);
    }else{echo "failed";}
?>