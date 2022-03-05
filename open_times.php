<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT open,close FROM account WHERE account_id = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info += ["open" => strval($row["open"])];
            $info += ["close" => strval($row["close"])];}
    
        echo json_encode($info);
    }else{echo "failed.";}
?>