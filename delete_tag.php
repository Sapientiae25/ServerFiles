<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];

        $sql = "DELETE FROM tag_jnct WHERE style_fk = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $style_id);
        $stmt->execute();
    }else{echo "failed";}
?>