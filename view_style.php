<?php
if (isset($_POST['user_fk']) && isset($_POST['style_fk'])){
    require_once 'conn.php';

    $user_fk = $_POST['user_fk'];
    $style_fk = $_POST['style_fk'];

    $sql = "SELECT * FROM viewed WHERE user_fk = ? AND style_fk = ?";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("ii", $user_fk,$style_fk);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows(); 

    if ($num == 0){
        $sql = "INSERT INTO viewed (user_fk,style_fk,view_date) VALUES (?,?,NOW())";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $user_fk,$style_fk);
        $stmt->execute();
    }
    else{
        $sql = "UPDATE viewed SET view_date = NOW() WHERE user_fk = ? AND style_fk = ?";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ii", $user_fk,$style_fk);
        $stmt->execute();
    }

    }
    else{echo "failed";}
?>