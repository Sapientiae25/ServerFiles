<?php
    if (isset($_POST['name']) && isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $name = $_POST['name'];

        $sql = "UPDATE account SET name = ? WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdiis", $name, $account_id);
        $stmt->execute();
            
    }else{echo "failed";}
?>