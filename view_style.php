<?php
if (isset($_POST['user_fk']) && isset($_POST['style_fk'])){
    require_once 'conn.php';

    $user_fk = $_POST['user_fk'];
    $style_fk = $_POST['style_fk'];
    
    $sql = "INSERT INTO viewed (user_fk,style_fk) VALUES (?,?)";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("ii", $user_fk,$style_fk);
    $stmt->execute();}
    else{echo "failed";}
?>