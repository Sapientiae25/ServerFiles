<?php
        require_once 'conn.php';

        $dt   = new DateTime();
        $date = $dt->createFromFormat('d/m/Y H:i', $d);
        $dte =  $date->format('Y-m-d H:i:s');
        echo $dte;
        // $m = "90";
        
        // $stmt= $conn->prepare($sql);
        // $stmt->bind_param("si", $dte,$m);
        // $stmt->execute();

        // $sql = "SELECT @endtime";
        
        // $stmt= $conn->prepare($sql);
        // $stmt->execute();
        // $result = $stmt->get_result(); 
    
        // while($row = mysqli_fetch_assoc($result)) {
        //     // $old = intval($row["past"]);
        // echo json_encode($row);
        // }

        
?>