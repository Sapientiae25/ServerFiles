<?php
    if (isset($_POST['password']) && isset($_POST['email']) && isset($_POST['gender'])){
        require_once 'conn.php';

        $password = $_POST['password'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];

        $sql = "SELECT user_id FROM users WHERE email = ? LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $number = mysqli_num_rows($result);
        $info = array();

        if ($number == 1){
            $info += ["exist" => 1];
        }else{
            $sql = "INSERT INTO users (password,email,number,gender) VALUES (?,?,'',?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $password, $email, $gender);
            $stmt->execute();
            $account_id = mysqli_insert_id($conn);

            $info += ["exist" => 0];
            $info += ["account_id" => $account_id];
        } 
        echo json_encode($info);
    }else{echo "failed";}
?>