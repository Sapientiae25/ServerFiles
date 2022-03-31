<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info,acc.name as account_name,jnct.account_fk,im.image_id,
        acc.account_id FROM style_likes AS lik
        INNER JOIN styles_jnct AS jnct ON jnct.style_fk = lik.style_fk
        INNER JOIN style AS st ON st.style_id = jnct.style_fk
        INNER JOIN account AS acc ON acc.account_id = jnct.account_fk
        LEFT JOIN style_images as im ON im.style_fk = jnct.style_fk
        WHERE lik.user_fk = ?
        GROUP BY st.style_id";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
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
            $rating = "";
            while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
            if (strlen($rating) == 0){$rating = "0.0";}

            $name = strval($row["name"]);
            $price = strval($row["price"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $style_info = strval($row["info"]);
            $account_fk = strval($row["account_fk"]);
            $account_name = strval($row["account_name"]);

            $info += ["account_id" => strval($row["account_id"])];
            $info += ["image_id" => strval($row["image_id"])];
            $info += ["rating" => $rating];
            $info += ["account_name" => $account_name];
            $info += ["account_fk" => $account_fk];
            $info += ["name" => $name];
            $info += ["price" => $price];
            $info += ["time" => $time];
            $info += ["max_time" => $max_time];
            $info += ["info" => $style_info];
            $info += ["style_id" => $style_id];
            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>