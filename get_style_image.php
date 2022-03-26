<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];

        $sql = "SELECT image_id FROM style_images WHERE style_fk = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();
        
        while($row = mysqli_fetch_assoc($result)) {array_push($infos, strval($row["image_id"]));}
        
        echo json_encode($infos);
    }else{echo "failed";}
?>