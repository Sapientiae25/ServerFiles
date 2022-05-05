<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT COUNT(viewed) AS num FROM booking WHERE account_fk = ? AND viewed = 0 AND cancel = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $count = 0;

        while($row = mysqli_fetch_assoc($result)) { $count = strval($row["num"]); }
        echo $count;
    }else{echo "failed";}
?>