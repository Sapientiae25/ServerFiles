<?php
    if (isset($_POST['account_id']) && isset($_POST['start']) && isset($_POST['diff'])
     && isset($_POST['style_id']) && isset($_POST['user_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        $start = $_POST['start'];
        $diff = $_POST['diff'];
        $user_id = $_POST['user_id'];
        $style_id = $_POST['style_id'];

        $sql = "SELECT ? > NOW() as past";
               
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $start);
        $stmt->execute();
        $result = $stmt->get_result(); 
    
        while($row = mysqli_fetch_assoc($result)) {
            $old = intval($row["past"]);

            if ($old == 0){
                $dt  = new DateTime();
                $date = $dt->createFromFormat('d/m/Y H:i', $start);
                $start_date = $date->format('Y-m-d H:i:s');

                $sql = "SET @endtime = (? + INTERVAL ? MINUTE)";
        
                $stmt= $conn->prepare($sql);
                $stmt->bind_param("ss", $start_date,$diff);
                $stmt->execute();
        
                $sql = "INSERT INTO booking (user_fk, account_fk, start, end, style_fk,viewed,cancel,user_viewed)
                 VALUES (?,?,?,@endTime,?,0,0,0)";
                        
                $stmt= $conn->prepare($sql);
                $stmt->bind_param("iisi", $user_id,$account_id,$start_date,$style_id);
                $stmt->execute();
            }

            echo $old;
        }




    }else{echo "failed";}
?>