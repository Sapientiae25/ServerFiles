<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $infos = array();

        $sql = "SELECT payment_id,privacy FROM account
        LEFT JOIN saloon_payment as pay ON pay.saloon_fk = account_id WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        
        while($row = mysqli_fetch_assoc($result)) {
            $infos += ["privacy" => strval($row["privacy"])];
            $infos += ["payment" => strval($row["payment_id"])];
         }
        echo json_encode($infos);
    }else{echo "failed";}
?>