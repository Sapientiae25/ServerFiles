<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT st.style_id, st.name, st.price, st.time, st.max_time, st.info,cast(bk.start as date)
         as s_date,DATE_FORMAT(bk.start,'%H:%i') as s_time,acc.name as account_name,ad.address,bk.booking_id,acc.account_id
          FROM booking AS bk
        INNER JOIN style AS st ON st.style_id = bk.style_fk
        INNER JOIN styles_jnct AS jnct ON jnct.style_fk = bk.style_fk
        INNER JOIN account AS acc ON acc.account_id = jnct.account_fk
        INNER JOIN address_jnct as adj ON adj.account_fk = jnct.account_fk
        INNER JOIN address as ad ON ad.address_id = adj.address_fk
        WHERE bk.user_fk = ? AND start > now()" ;

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

            array_push($infos,$book);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>