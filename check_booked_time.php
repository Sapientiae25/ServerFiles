<?php
    if (isset($_POST['start'])){
        require_once 'conn.php';

        $start = $_POST['start'];

        $sql = "SELECT ? < NOW() as past";
               
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $start);
        $stmt->execute();
        $result = $stmt->get_result(); 
    
        while($row = mysqli_fetch_assoc($result)) {
            $old = intval($row["past"]);
            echo $old;
        }


    }else{echo "failed";}
?>