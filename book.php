<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['diff'])
     && isset($_POST['style_id']) && isset($_POST['user_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $start = $_POST['start'];
        $diff = $_POST['diff'];
        $user_id = $_POST['user_id'];
        $style_id = $_POST['style_id'];

        $sql = "SET @endtime = ADDTIME(?,?)";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss", $start,$diff);
        $stmt->execute();

        $sql = "INSERT INTO booking (user_fk, account_fk, start, end, style_fk,viewed) VALUES (?,?,?,@endTime,?,0)";
                
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("iisi", $user_id,$account_id,$start,$style_id);
        $stmt->execute();


    }else{echo "failed";}
?>