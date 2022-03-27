<?php
if (isset($_POST['text'])){
    require_once 'conn.php';

    $text = $_POST['text'];
    
    $sql = "SELECT st.style_id, st.name, st.price, st.time, st.max_time, st.info,jnct.account_fk,ac.name as ac_name,im.image_id
     FROM styles_jnct AS jnct
    INNER JOIN style AS st ON st.style_id = jnct.style_fk
    INNER JOIN review AS rv ON rv.style_fk = jnct.style_fk
    LEFT JOIN style_images as im ON im.style_fk = jnct.style_fk
    WHERE st.name LIKE '%".$text."%' GROUP BY st.style_id";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $infos = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();
        $style_id = strval($row["style_id"]);
        $sql = "SELECT AVG(rating) as rating FROM reviews WHERE style_fk = ?" ;
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $style_id);
        $stmt->execute();
        $res = $stmt->get_result(); 
        $rating = 0;
        while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
        $name = strval($row["name"]);
        $price = strval($row["price"]);
        $time = strval($row["time"]);
        $max_time = strval($row["max_time"]);
        $style_info = strval($row["info"]);
        $account_fk = strval($row["account_fk"]);
        $ac_name = strval($row["ac_name"]);

        $info += ["image_id" => strval($row["image_id"])];
        $info += ["rating" => $rating];
        $info += ["name" => $name];
        $info += ["price" => $price];
        $info += ["time" => $time];
        $info += ["max_time" => $max_time];
        $info += ["info" => $style_info];
        $info += ["style_id" => $style_id];
        $info += ["account_fk" => $account_fk];
        $info += ["account_name" => $ac_name];

        array_push($infos,$info);
    }
    echo json_encode($infos);
}
    else{echo "failed";}
?>