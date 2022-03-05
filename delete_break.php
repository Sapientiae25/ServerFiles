<?php
    if (isset($_POST['break_id'])){
        require_once 'conn.php';

        $break_id = $_POST['break_id'];

        $sql = "DELETE FROM breaks WHERE break_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $break_id);
        $stmt->execute();
    }else{echo "failed";}
?>