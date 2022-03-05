<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];
        
        $sql = "SELECT gender,length FROM filters AS jnct
        INNER JOIN style AS st ON st.style_id = jnct.style_fk
        WHERE jnct.account_fk = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $info["gender"] = strval($row["gender"]);
            $info["length"] = strval($row["length"]);
        }
    
        echo json_encode($info);
    }else{echo "failed.";}
?>