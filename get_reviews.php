<?php
    if (isset($_POST['style_id'])){
        require_once 'conn.php';

        $style_id = $_POST['style_id'];
        $infos = array();

        $sql = "SELECT review,rating,time FROM reviews WHERE style_fk = ? LIMIT 10";
        
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $style_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $info += ["review" => strval($row["review"])];
            $info += ["rating" => strval($row["rating"])];
            $info += ["date" => strval($row["time"])];

            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>