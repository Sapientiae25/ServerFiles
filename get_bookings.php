<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $dates = array();

        $sql = "SELECT start, end, st.name,booking_id,style_fk,st.price,us.email FROM booking
            INNER JOIN style AS st ON st.style_id = style_fk
            INNER JOIN users AS us ON us.user_id = user_fk
            WHERE account_fk = ? AND cast(start as date) >= now()" ;

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $book = array();
            $start = strval($row["start"]);
            $end = strval($row["end"]);
            $name = strval($row["name"]);
            $booking_id = strval($row["booking_id"]);
            $style_id = strval($row["style_fk"]);
            $price = strval($row["price"]);
            $email = strval($row["email"]);

            $book += ["start" => $start];
            $book += ["end" => $end];
            $book += ["booking_id" => $booking_id];
            $book += ["name" => $name];
            $book += ["style_id" => $style_id];
            $book += ["price" => $price];
            $book += ["email" => $email];

            array_push($dates,$book);
        }
        echo json_encode($dates);
    }else{echo "failed";}
?>