<?php
    if (isset($_POST['email']) && isset($_POST['password'])){
        require_once 'conn.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT account_id,name,address,postcode,open,close FROM account
            INNER JOIN address_jnct as jnct ON jnct.account_fk = account_id
            INNER JOIN address as ad ON ad.address_id = jnct.address_fk
         WHERE email = ? AND password = ? LIMIT 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ss", $email,$password);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $number = mysqli_num_rows($result);
        $info = array();

        if ($number == 0){
            $info += ["exist" => 0];
        }else{
            while($row = mysqli_fetch_assoc($result)) {

                $account_id = strval($row["account_id"]);
                $sql = "SELECT AVG(rating) as rating FROM saloon_reviews WHERE account_fk = ?" ;
                $stmt= $conn->prepare($sql);
                $stmt->bind_param("i", $account_id);
                $stmt->execute();
                $res = $stmt->get_result(); 
                while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
                if (strlen($rating) == 0){$rating = "0.0";}
                $info += ["rating" => $rating];
                $info += ["exist" => 1];
                $info += ["account_id" => $account_id];
                $info += ["name" => strval($row["name"])];
                $info += ["address" => strval($row["address"])];
                $info += ["postcode" => strval($row["postcode"])];
                $info += ["open" => strval($row["open"])];
                $info += ["close" => strval($row["close"])];
            }
        }
        echo json_encode($info);
    }else{echo "failed.";}
?>