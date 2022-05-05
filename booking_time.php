<?php
    if (isset($_POST['account_id']) && isset($_POST['date'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $date = $_POST['date'];
        $infos = array();

        $sql = "SELECT open,close FROM account WHERE account_id = ?";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $infos += ["open" => strval($row["open"])];
            $infos += ["close" => strval($row["close"])];
        }

        $sql = "SELECT cast(start as time),cast(end as time) FROM booking
        WHERE account_fk = ? AND cast(start as date) = ? AND cast(end as date) = ? AND cancel = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("iss", $account_id,$date,$date);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $dates = array();

        while($row = mysqli_fetch_assoc($result)) {
            $date_obj = array();
            $date_obj += ["start" => strval($row["start"])];
            $date_obj += ["end" => $end];
            array_push($dates,$date_obj);
        }
        $infos += ["dates" => $dates];
        echo json_encode($infos);
    }else{echo "failed";}
?>