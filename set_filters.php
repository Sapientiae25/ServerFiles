<?php
    if (isset($_POST['style_fk']) && isset($_POST['gender']) && isset($_POST['length'])){
        require_once 'conn.php';

        $style_fk = $_POST['style_fk'];
        $gender = $_POST['gender'];
        $length = $_POST['length'];
    
        $sql = "INSERT INTO filters (style_fk, gender, length) VALUES (?,?,?)" ;

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("sss", $style_fk,$gender,$length);
        $stmt->execute();

    }else{echo "failed";}
?>