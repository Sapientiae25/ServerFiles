<?php
    if (isset($_POST['user_id']) && isset($_POST['location_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $location_id = $_POST['location_id'];

        $sql = "UPDATE saved_locations SET chosen = 0 WHERE user_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
        $stmt->execute();

        $sql = "UPDATE saved_locations SET chosen = 1 WHERE user_fk = ? AND location_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id,$location_id);
        $stmt->execute();
    }
    else{echo "failed"}
?>