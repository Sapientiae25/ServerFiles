<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];

        $sql = "SELECT st.name, st.price, st.time, st.max_time, us.email, booking_id FROM booking
        INNER JOIN style as st ON booking.style
        INNER JOIN users as us ON booking.user_fk
        WHERE style_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $tags = array();
            $name = strval($row["name"]);
            $price = strval($row["price"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $booking_id = strval($row["booking_id"]);

            $info += ["name" => $name];
            $info += ["price" => $price];
            $info += ["time" => $time];
            $info += ["email" => $email];
            $info += ["max_time" => $max_time];
            $info += ["booking_id" => $booking_id];
            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>