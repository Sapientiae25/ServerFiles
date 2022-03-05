<?php
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['time']) && isset($_POST['style_id'])
     && isset($_POST['account_id']) && isset($_POST['info']) && isset($_POST['length']) && isset($_POST['gender'])){
        require_once 'conn.php';

        $name = $_POST['name'];
        $price = $_POST['price'];
        $time = $_POST['time'];
        $info = $_POST['info'];
        $style_id = $_POST['style_id'];
        $length = $_POST['length'];
        $gender = $_POST['gender'];

        $sql = "UPDATE style SET name = ?,price = ?,time = ?,info = ? WHERE style_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdisi", $name, $price,$time,$info,$style_id);
        $stmt->execute();

        $sql = "UPDATE filters SET length = ?,gender = ? WHERE style_fk = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $length, $gender,$style_id);
        $stmt->execute();

        echo json_encode($return_info);
    }else{echo "failed";}
?>