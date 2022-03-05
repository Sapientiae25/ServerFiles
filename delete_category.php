<?php
    if (isset($_POST['category_id'])){
        require_once 'conn.php';

        $category_id = $_POST['category_id'];
        $style_id = $_POST['style_id'];

        $sql = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
    }else{echo "failed";}
?>