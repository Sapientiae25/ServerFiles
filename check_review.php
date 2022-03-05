<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $info = array();

        $sql = "SELECT review,rating,time FROM reviews WHERE user_fk = ? ";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $info += ["review" => strval($row["review"])];
            $info += ["rating" => strval($row["rating"])];
            echo json_encode($info);
        }
    }else{echo "failed";}
?>