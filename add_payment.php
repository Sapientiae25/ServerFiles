<?php
    if (isset($_POST['number']) && isset($_POST['cvv']) && isset($_POST['expiry']) && isset($_POST['saloon_fk'])){
        require_once 'conn.php';

        $number = $_POST['number'];
        $cvv = $_POST['cvv'];
        $expiry = $_POST['expiry'];
        $saloon_fk = $_POST['saloon_fk'];

        $sql = "INSERT INTO payment (number,cvv,expiry,saloon_fk) VALUES (?,?,?,?)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("sssi", $number,$cvv,$expiry,$saloon_fk);
        $stmt->execute();}
    else{echo "failed";}
?>