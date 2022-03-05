<?php
    if (isset($_POST['category_id']) && isset($_POST['style_id'])){
        require_once 'conn.php';

        $category_id = $_POST['category_id'];
        $style_id = $_POST['style_id'];

        $sql = "DELETE FROM category_jnct WHERE category_fk = ? AND style_fk = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $category_id,$style_id);
        $stmt->execute();
    }else{echo "failed";}
?>