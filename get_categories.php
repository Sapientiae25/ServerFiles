<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        
        $sql = "SELECT category_id, category FROM categories AS cat WHERE account_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $id = strval($row["category_id"]);
            $image_id = "";

            $sql = "SELECT im.image_id FROM category_jnct AS jnct
            INNER JOIN style_images AS im ON im.style_fk = jnct.style_fk
            INNER JOIN categories AS cat ON cat.category_id = jnct.category_fk
            WHERE cat.account_fk = ? AND jnct.category_fk = ?";
        
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("ii", $account_id,$id);
            $stmt->execute();
            $result2 = $stmt->get_result(); 

            while($row2 = mysqli_fetch_assoc($result2)) { $image_id = strval($row2["image_id"]); }

            $info += ["category" => strval($row["category"])];
            $info += ["id" => $id];
            $info += ["image_id" => $image_id];

            array_push($infos,$info);
        }

        
        echo json_encode($infos);
    }else{echo "failed";}
?>