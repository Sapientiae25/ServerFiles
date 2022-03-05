<?php
    if (isset($_POST['card_id'])){
        require_once 'conn.php';

        $card_id = $_POST['card_id'];

        $sql = "DELETE FROM payment WHERE card_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $card_id);
        $stmt->execute();}
    else{echo "failed";}
?>