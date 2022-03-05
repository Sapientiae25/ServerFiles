<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT st.style_id, st.name, cat.category_fk FROM style AS st
        LEFT JOIN category_jnct AS cat ON cat.style_fk = st.style_id
        INNER JOIN styles_jnct AS jnct ON jnct.style_fk = st.style_id
        WHERE jnct.account_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();

        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $style_id = strval($row["style_id"]);
            $name = strval($row["name"]);
            $category_fk = strval($row["category_fk"]);

            $info += ["name" => $name];
            $info += ["style_id" => $style_id];
            $info += ["category_fk" => $category_fk];
            
            array_push($infos,$info);
        }
        echo json_encode($infos);
    }else{echo "failed";}
?>