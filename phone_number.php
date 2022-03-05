<?php
    if (isset($_POST['number']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $number = $_POST['number'];

        $sql = "UPDATE account SET number = ? WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $number, $account_id);
        $stmt->execute();
            
    }else{echo "failed";}
?>