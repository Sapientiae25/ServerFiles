<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $current_id = $_POST['style_id'];


        $sql = "SELECT fil.gender, fil.length FROM style
        INNER JOIN filters as fil ON fil.style_fk = style_id
        WHERE style_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$current_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {

            $gender = $_POST['gender'];
            $length = $_POST['length'];

            $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info,st.privacy,im.image_id FROM styles_jnct AS jnct
            INNER JOIN style AS st ON st.style_id = jnct.style_fk
            LEFT JOIN style_images AS im ON im.style_fk = jnct.style_fk
            INNER JOIN filters as fil ON fil.style_fk = jnct.style_fk
            WHERE st.style_id <> ? AND fil.gender = ? AND fil.length = ? GROUP BY st.style_id";

            $stmt= $conn->prepare($sql);
            $stmt->bind_param("iii",$current_id,$gender,$length);
            $stmt->execute();
            $result = $stmt->get_result(); 

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
                $privacy = strval($row["privacy"]);
                $image_id = strval($row["image_id"]);

                $info += ["image_id" => $image_id];
                $info += ["rating" => $rating];
                $info += ["name" => $name];
                $info += ["price" => $price];
                $info += ["time" => $time];
                $info += ["max_time" => $max_time];
                $info += ["info" => $style_info];
                $info += ["style_id" => $style_id];
                $info += ["privacy" => $privacy];

                array_push($infos,$info);
            }
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>