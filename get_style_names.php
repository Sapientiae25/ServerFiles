<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT st.style_id,st.name,st.price,st.time,st.max_time,st.info FROM styles_jnct AS jnct
        INNER JOIN style AS st ON st.style_id = jnct.style_fk
        INNER JOIN account AS acc ON acc.account_id = jnct.account_fk
        WHERE jnct.account_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $tags = array();
            $style_id = strval($row["style_id"]);
            $name = strval($row["name"]);
            $price = strval($row["price"]);
            $time = strval($row["time"]);
            $max_time = strval($row["max_time"]);
            $style_info = strval($row["info"]);

            $info += ["name" => $name];
            $info += ["style_id" => $style_id];
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>