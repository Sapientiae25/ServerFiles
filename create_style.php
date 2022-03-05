<?php
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['time']) && isset($_POST['account_id']) && isset($_POST['info'])){
        require_once 'conn.php';

        $name = $_POST['name'];
        $price = $_POST['price'];
        $time = $_POST['time'];
        $account_id = $_POST['account_id'];
        $info = $_POST['info'];

        $sql = "INSERT INTO style (name, price, time, info) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdss", $name, $price, $time, $info);
        $stmt->execute();
        $style_id = strval(mysqli_insert_id($conn));

        $sql = "INSERT INTO styles_jnct (style_fk, account_fk) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $style_id, $account_id);
        $stmt->execute();

    echo $style_id;
    }else{echo "failed";}
?>