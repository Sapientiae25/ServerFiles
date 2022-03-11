<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT image_id FROM saloon_images WHERE saloon_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();
        
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {array_push($infos, strval($row["image_id"]));}
        
        echo json_encode($infos);
    }else{echo "failed";}
?>