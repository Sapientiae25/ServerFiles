<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];
        
        $sql = "SELECT gender,length FROM filters WHERE style_fk = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();
        
        while($row = mysqli_fetch_assoc($result)) {
            $info["gender"] = strval($row["gender"]);
            $info["length"] = strval($row["length"]);
        }
    
        echo json_encode($info);
    }else{echo "failed.";}
?>