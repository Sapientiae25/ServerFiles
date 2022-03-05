<?php
    if (isset($_POST['email'])){
        require_once 'conn.php';

        $email = $_POST['email'];

        $sql = "SELECT account_id FROM account WHERE email = ? LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $number = mysqli_num_rows($result);
        echo json_encode($number);
    }else{echo "failed";}
?>