<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        
        $sql = "SELECT category_id, category,im.image_id FROM categorY_jnct AS jnct
            LEFT JOIN categories AS cat ON cat.category_id = jnct.category_fk
            LEFT JOIN style_images AS im ON im.style_fk = jnct.style_fk
             WHERE account_fk = ? GROUP BY category_id";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();

            $info += ["id" => strval($row["category_id"])];
            $info += ["category" => strval($row["category"])];
            $info += ["image_id" => strval($row["image_id"])];

            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>