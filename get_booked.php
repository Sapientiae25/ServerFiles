<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $return = array();

        $sql = "SELECT st.style_id, st.name, st.price, st.time, st.max_time, st.info,DATE_FORMAT(bk.start,'%d/%m/%Y') as s_date,im.image_id,
        DATE_FORMAT(bk.start,'%H:%i') as s_time,acc.name as account_name,ad.address,bk.booking_id,acc.account_id
          FROM booking AS bk
        INNER JOIN style AS st ON st.style_id = bk.style_fk
        INNER JOIN styles_jnct AS jnct ON jnct.style_fk = bk.style_fk
        LEFT JOIN style_images as im ON im.style_fk = bk.style_fk
        INNER JOIN account AS acc ON acc.account_id = jnct.account_fk
        INNER JOIN address_jnct as adj ON adj.account_fk = jnct.account_fk
        INNER JOIN address as ad ON ad.address_id = adj.address_fk
        WHERE bk.user_fk = ? AND bk.start > now() - INTERVAL 7 DAY AND cancel = 0" ;

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $style_id = strval($row["style_id"]);
            $sql = "SELECT AVG(rating) as rating FROM reviews WHERE style_fk = ?" ;
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $style_id);
            $stmt->execute();
            $res = $stmt->get_result(); 
            $rating = "";
            while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
            if (strlen($rating) == 0){$rating = "0.0";}

            $book = array();
            $name = strval($row["name"]);
            $booking_id = strval($row["booking_id"]);
            $price = strval($row["price"]);
            $s_date = strval($row["s_date"]);
            $s_time = strval($row["s_time"]);
            $account_name = strval($row["account_name"]);
            $address = strval($row["address"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $info = strval($row["info"]);
            $account_id = strval($row["account_id"]);

            $book += ["account_id" => $account_id];
            $book += ["time" => $time];
            $book += ["max_time" => $max_time];
            $book += ["info" => $info];
            $book += ["rating" => $rating];
            $book += ["s_date" => $s_date];
            $book += ["price" => $price];
            $book += ["s_time" => $s_time];
            $book += ["account_name" => $account_name];
            $book += ["address" => $address];
            $book += ["booking_id" => $booking_id];
            $book += ["name" => $name];
            $book += ["style_id" => $style_id];
            $book += ["image_id" => strval($row["image_id"])];

            array_push($infos,$book);}


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

        $return += ["cancel" => $cancels];
        $return += ["bookings" => $infos];

        $sql = "UPDATE cancelled AS ca
        INNER JOIN booking AS bk ON bk.booking_id = booking_fk 
         SET ca.viewed = 1 WHERE bk.user_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        $sql = "UPDATE booking SET user_viewed = 1 WHERE account_fk = ? AND user_viewed = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();

        echo json_encode($return);
    }else{echo "failed";}
?>