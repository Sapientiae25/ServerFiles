<?php
        require_once 'conn.php';


        $sql = "SELECT COUNT(viewed) AS num FROM booking WHERE account_fk = 10 AND viewed = 0";

        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $count = 0;

        while($row = mysqli_fetch_assoc($result)) { $count = strval($row["num"]); }
        echo $count;
?>