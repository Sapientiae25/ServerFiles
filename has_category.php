<?php
    if (isset($_POST['account_fk'])){
        require_once 'conn.php';

        $account_fk = $_POST['account_fk'];
        $result = 1;

        $sql = "SELECT 1 FROM categories WHERE account_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_fk);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows(); 

        if ($num == 0){$result = 0;}

        echo $result;
    }else{echo "failed";}
?>