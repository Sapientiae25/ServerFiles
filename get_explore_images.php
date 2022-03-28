<?php
  if (isset($_POST['gender'])){
    require_once 'conn.php';

    $gender = $_POST['gender'];

    $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info,acc.account_id,acc.name as account_name,im.image_id
        FROM styles_jnct as jnct
        INNER JOIN account as acc ON acc.account_id = jnct.account_fk
        INNER JOIN style as st ON st.style_id = jnct.style_fk
        INNER JOIN filters as fil ON fil.style_fk = jnct.style_fk
        INNER JOIN style_images as im ON im.style_fk = jnct.style_fk
        GROUP BY st.style_id
        ORDER BY (CASE WHEN fil.gender = ? THEN 3 WHEN fil.gender = 2 THEN 2 ELSE 0 END) DESC ";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("i", $gender);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $infos = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();
        $style_id = strval($row["style_id"]);
        $name = strval($row["name"]);
        $price = strval($row["price"]);
        $time = strval($row["time"]);
        $max_time = strval($row["max_time"]);
        $style_info = strval($row["info"]);
        $account_id = strval($row["account_id"]);
        $account_name = strval($row["account_name"]);

        $info += ["image_id" => strval($row["image_id"])];
        $info += ["account_name" => $account_name];
        $info += ["name" => $name];
        $info += ["price" => $price];
        $info += ["time" => $time];
        $info += ["max_time" => $max_time];
        $info += ["info" => $style_info];
        $info += ["style_id" => $style_id];
        $info += ["account_id" => $account_id];
        array_push($infos,$info);
    }
    echo json_encode($infos);
}else{echo "failed";}
?>