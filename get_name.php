<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT name,number FROM account WHERE account_id = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info += ["name" => strval($row["name"])];
            $info += ["number" => strval($row["number"])];}
    
        echo json_encode($info);
    }else{echo "failed.";}
?>