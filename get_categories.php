<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        
        $sql = "SELECT category_id, category FROM categories WHERE account_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();

            $info += ["id" => strval($row["category_id"])];
            $info += ["category" => strval($row["category"])];
            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>