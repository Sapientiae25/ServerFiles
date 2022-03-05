<?php
if (isset($_POST['style_id'])){
    require_once 'conn.php';

    $style_id = $_POST['style_id'];
    
    $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info,acc.account_id,acc.name as account_name
        FROM styles_jnct as jnct
        INNER JOIN account as acc ON acc.account_id = jnct.account_fk
        INNER JOIN style as st ON st.style_id = jnct.style_fk
        WHERE st.style_id = ?";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("i", $style_id);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $info = array();

    while($row = mysqli_fetch_assoc($result)) {
        $style_id = strval($row["style_id"]);
        $name = strval($row["name"]);
        $price = strval($row["price"]);
        $time = strval($row["time"]);
        $max_time = strval($row["max_time"]);
        $style_info = strval($row["info"]);
        $account_id = strval($row["account_id"]);
        $account_name = strval($row["account_name"]);

        $info += ["account_name" => $account_name];
        $info += ["name" => $name];
        $info += ["price" => $price];
        $info += ["time" => $time];
        $info += ["max_time" => $max_time];
        $info += ["info" => $style_info];
        $info += ["style_id" => $style_id];
        $info += ["account_id" => $account_id];
    }
    echo json_encode($info);}
    else{echo "failed";}
?>