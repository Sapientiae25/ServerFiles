<?php
    if (isset($_POST['location_id'])){
        require_once 'conn.php';

        $location_id = $_POST['location_id'];

        $sql = "DELETE FROM saved_locations WHERE location_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
        $stmt->execute();}
    else{echo "failed"}
?>