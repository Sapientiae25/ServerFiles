<?php
    if (isset($_POST['category_id'])){
        require_once 'conn.php';

        $category_id = $_POST['category_id'];

        $sql = "SELECT st.image_id FROM category_jnct as jnct
                INNER JOIN style_images as st ON st.style_fk = jnct.style_fk
                WHERE jnct.category_fk = ? LIMIT 5";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$category_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {array_push($infos, strval($row["image_id"]));}

        echo json_encode($infos);
        
    }else{echo "failed";}
?>