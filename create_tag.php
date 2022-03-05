<?php
    if (isset($_POST['style_id']) && isset($_POST['tag'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];
        $tag = $_POST['tag'];
        $sql = "INSERT INTO tag_jnct (style_fk, tag) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $style_id, $tag);
        $stmt->execute();
    }else{echo "failed";}
?>