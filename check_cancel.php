<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT COUNT(ca.viewed) AS num FROM cancelled as ca
        INNER JOIN booking AS bk ON bk.booking_id = ca.booking_fk 
        WHERE bk.user_fk = ? AND ca.viewed = 0";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $count = 0;

        while($row = mysqli_fetch_assoc($result)) { $count = strval($row["num"]); }
        echo $count;
    }else{echo "failed";}
?>