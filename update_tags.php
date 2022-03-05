<?php
    if (isset($_POST['tag_id']) && isset($_POST['tag'])){
        require_once 'conn.php';

        $tag_id = $_POST['tag_id'];
        $tag = $_POST['tag'];

        $sql = "UPDATE tag_jnct SET tag = ? WHERE tag_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $tag, $tag_id);
        $stmt->execute();
        
    }else{echo "failed";}
?>