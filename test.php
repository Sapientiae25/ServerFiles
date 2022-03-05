<?php
        require_once 'conn.php';

        $account_id = 10;
        $sql = "SELECT AVG(rating) as rating FROM saloon_reviews WHERE account_fk = ?" ;
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $res = $stmt->get_result(); 
        $rating = 0;
        while($row2 = mysqli_fetch_assoc($res)) {
             $rating = strval($row2["rating"]);
             
            }
        echo "rr";
        echo strlen($rating);
        
?>