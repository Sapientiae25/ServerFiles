<?php
    if (isset($_POST['datetime']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $datetime = $_POST['datetime'];
        $account_id = $_POST['account_id'];

        $result = 1;

        $sql = "SELECT booking_id FROM booking WHERE account_fk = ? AND ? BETWEEN cast(start as datetime) and cast(end as datetime)";
               
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("is", $account_id,$datetime);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows(); 

        if ($num == 0){$result = 0;}

        echo $result;
    }else{echo "failed";}
?>