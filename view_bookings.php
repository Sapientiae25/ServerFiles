<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "UPDATE booking SET viewed = 1 WHERE account_fk = ? AND viewed = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
    }else{echo "failed";}
?>