<?php
    if (isset($_POST['time']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $time = $_POST['time'];

        $sql = "UPDATE account SET close = ? WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $time, $account_id);
        $stmt->execute();
            
    }else{echo "failed";}
?>