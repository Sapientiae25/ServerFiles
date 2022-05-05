<?php
    if (isset($_POST['booking_id'])){
        require_once 'conn.php';

        $booking_id = $_POST['booking_id'];

        $sql = "SELECT st.name, st.price, st.time, st.max_time, us.email,FROM booking AS bk
        INNER JOIN style as st ON bk.style_fk
        INNER JOIN users as us ON bk.user_fk
        WHERE bk.booking_id = ? AND cancel = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $tags = array();
            $name = strval($row["name"]);
            $price = strval($row["price"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $email = strval($row["email"]);

            $info += ["name" => $name];
            $info += ["price" => $price];
            $info += ["time" => $time];
            $info += ["email" => $email];
            $info += ["max_time" => $max_time];
        }
        echo json_encode($info);
    }else{echo "failed";}
?>