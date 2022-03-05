<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];
        
        $sql = "SELECT ad.city,ad.postcode,ad.country,ad.address,ad.town FROM address_jnct AS jnct
        INNER JOIN address AS ad ON ad.address_id = jnct.address_fk
        WHERE jnct.account_fk = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while($row = mysqli_fetch_assoc($result)) {
            $info["city"] = strval($row["city"]);
            $info["postcode"] = strval($row["postcode"]);
            $info["country"] = strval($row["country"]);
            $info["address"] = strval($row["address"]);
            $info["town"] = strval($row["town"]);
        }
    
        echo json_encode($info);
    }else{echo "failed.";}
?>