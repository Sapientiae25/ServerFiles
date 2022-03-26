<?php
        require_once 'conn.php';

        function object_to_array($data)
        {
            if (is_array($data) || is_object($data))
            {
                $result = [];
                foreach ($data as $key => $value)
                {
                    $result[$key] = (is_array($data) || is_object($data)) ? object_to_array($value) : $value;
                }
                return $result;
            }
            return $data;
        }

        $json = file_get_contents('php://input');

        $data = json_decode($json);
        $obj = $data[0];
        $obj = object_to_array($obj);

        $gender = $obj["gender"];
        $length = $obj["length"];
        $length = implode("','",$length);

        $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info,jnct.account_fk,acc.name as account_name,ad.address,
            im.image_id FROM styles_jnct AS jnct
            INNER JOIN style AS st ON st.style_id = jnct.style_fk
            LEFT JOIN style_images as im ON im.style_fk = jnct.style_fk
            INNER JOIN address_jnct as adj ON adj.account_fk = jnct.account_fk
            INNER JOIN address as ad ON ad.address_id = adj.address_fk
            INNER JOIN account AS acc ON acc.account_id = jnct.account_fk
            INNER JOIN filters AS fil ON fil.style_fk = jnct.style_fk
            WHERE IF(? = 2, true, fil.gender = ? OR fil.gender=2) OR fil.length IN ('".$length."')";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $gender,$gender);
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

            $account_fk = strval($row["account_fk"]);
            $name = strval($row["name"]);
            $price = strval($row["price"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $style_info = strval($row["info"]);
            $account_name = strval($row["account_name"]);
            $address = strval($row["address"]);
            $image_id = strval($row["image_id"]);

            $info += ["image_id" => $image_id];
            $info += ["address" => $address];
            $info += ["rating" => $rating];
            $info += ["account_name" => $account_name];
            $info += ["account_fk" => $account_fk];
            $info += ["name" => $name];
            $info += ["price" => $price];
            $info += ["time" => $time];
            $info += ["max_time" => $max_time];
            $info += ["info" => $style_info];
            $info += ["style_id" => $style_id];
            array_push($infos,$info);}

        echo json_encode($infos);
?>