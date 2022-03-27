<?php
    if (isset($_POST['category_id'])){
        require_once 'conn.php';

        $category_id = $_POST['category_id'];

        $sql = "SELECT st.image_id,st.style_fk FROM category_jnct as jnct
                LEFT JOIN style_images as im ON im.style_fk = jnct.style_fk
                WHERE jnct.category_fk = ? LIMIT 5 GROUP BY st.style_id";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$category_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();

            $info += ["image_id" => strval($row["image_id"])];
            $info += ["style_id" => strval($row["style_fk"])];
            
            array_push($infos, $info);}

        echo json_encode($infos);
        
    }else{echo "failed";}
?>