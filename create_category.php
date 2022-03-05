<?php
    if (isset($_POST['category']) && isset($_POST['account_fk'])){
        require_once 'conn.php';

        $category = $_POST['category'];
        $account_fk = $_POST['account_fk'];
        $info = array();
        
        $sql = "SELECT category_id FROM categories WHERE category = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $name);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows(); 

        $sql = "INSERT INTO categories (category,account_fk) VALUES (?,?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("si", $category,$account_fk);
        $stmt->execute();
        $last_id = mysqli_insert_id($conn);

        $info += ["category_id" => $last_id];
        $info += ["exist" => $num];

        echo json_encode($info);
    }else{echo "failed";}
?>