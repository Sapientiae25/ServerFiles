<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info FROM styles_jnct AS jnct
        INNER JOIN style AS st ON st.style_id = jnct.style_fk
        WHERE jnct.account_fk = ? and st.privacy = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $style_id = strval($row["style_id"]);
            $sql = "SELECT AVG(rating) as rating FROM reviews WHERE style_fk = ?" ;
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i",$style_id);
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

            $info += ["rating" => $rating];
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