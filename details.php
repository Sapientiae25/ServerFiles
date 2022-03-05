<?php
    if (isset($_POST['account_id'])){
        require_once 'conn.php';

        $account_id = $_POST['account_id'];

        $sql = "SELECT name,number,password,open,close FROM account WHERE account_id = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $info = array();

        $info += ["city" => ""];
        $info += ["postcode" => ""];
        $info += ["country" => ""];
        $info += ["address" => ""];

        while($row = mysqli_fetch_assoc($result)) {
            $info += ["password" => strval($row["password"])];
            $info += ["number" => strval($row["number"])];
            $info += ["name" => strval($row["name"])];
            $info += ["open" => strval($row["open"])];
            $info += ["close" => strval($row["close"])];
        }
        
        $sql = "SELECT ad.city,ad.postcode,ad.country,ad.address FROM address_jnct AS jnct
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
        }
    
        echo json_encode($info);
    }else{echo "failed.";}
?>