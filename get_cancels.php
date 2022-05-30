<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT reason,ac.name as account_name,ac.email,st.name,st.time,st.info,st.style_id,account_id,ad.address,st.price,
        DATE_FORMAT(bk.start,'%d/%m/%Y') as s_date,DATE_FORMAT(bk.start,'%H:%i') as s_time,im.image_id FROM cancelled as ca
        INNER JOIN booking AS bk ON bk.booking_id = booking_fk 
        INNER JOIN account AS ac ON ac.account_id = ca.account_fk
        INNER JOIN address_jnct as adj ON adj.account_fk = ca.account_fk
        INNER JOIN address as ad ON ad.address_id = adj.address_fk
        INNER JOIN style AS st ON st.style_id = bk.style_fk
        LEFT JOIN style_images as im ON im.style_fk = bk.style_fk
        WHERE bk.user_fk = ? AND (bk.start > now() - INTERVAL 7 DAY OR ca.viewed = 0)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $cancels = array();
        
        while($row = mysqli_fetch_assoc($result)) {
            $cancel = array();
            $style_id = strval($row["style_id"]);

            $sql = "SELECT AVG(rating) as rating FROM reviews WHERE style_fk = ?" ;
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $style_id);
            $stmt->execute();
            $res = $stmt->get_result(); 
            $rating = "";
            while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
            if (strlen($rating) == 0){$rating = "0.0";}

            $cancel += ["reason" => strval($row["reason"])];
            $cancel += ["address" => strval($row["address"])];
            $cancel += ["price" => strval($row["price"])];
            $cancel += ["s_date" => strval($row["s_date"])];
            $cancel += ["s_time" => strval($row["s_time"])];
            $cancel += ["account_name" => strval($row["account_name"])];
            $cancel += ["name" => strval($row["name"])];
            $cancel += ["email" => strval($row["email"])];
            $cancel += ["account_id" => strval($row["account_id"])];
            $cancel += ["info" => strval($row["info"])];
            $cancel += ["time" => strval($row["time"])];
            $cancel += ["image_id" => strval($row["image_id"])];
            $cancel += ["style_id" => $style_id];
            $cancel += ["rating" => $rating];

            array_push($cancels,$cancel);}

        $sql = "UPDATE cancelled AS ca
        INNER JOIN booking AS bk ON bk.booking_id = booking_fk 
         SET ca.viewed = 1 WHERE bk.user_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        echo json_encode($cancels);
    }else{echo "failed";}
?>