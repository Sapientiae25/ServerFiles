<?php
    if (isset($_POST['email']) && isset($_POST['password'])){
        require_once 'conn.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT user_id,number,gender FROM users WHERE email = ? AND password = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss", $email,$password);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $number = mysqli_num_rows($result);
        $info = array();

        if ($number == 0){
            $info += ["exist" => 0];
        }else{
            while($row = mysqli_fetch_assoc($result)) {
                $info += ["exist" => 1];
                $info += ["account_id" => strval($row["user_id"])];
                $info += ["gender" => strval($row["gender"])];
                $info += ["number" => strval($row["number"])];
            }
        }
        echo json_encode($info);}
    else{echo "failed";}
?>