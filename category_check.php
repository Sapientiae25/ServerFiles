<?php
    if (isset($_POST['name'])){
        require_once 'conn.php';

        $name = $_POST['name'];
        $result = 1;

        $sql = "SELECT category_id FROM categories WHERE category = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $name);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows(); 

        if ($num == 0){$result = 0;}

        echo $result;
    }else{echo "failed";}
?>