<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT location_id,address,city,country,postcode,chosen,town FROM saved_locations WHERE user_fk = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();
    
        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $city = strval($row["city"]);
            $country = strval($row["country"]);
            $address = strval($row["address"]);
            $postcode = strval($row["postcode"]);
            $location_id = strval($row["location_id"]);
            $chosen = strval($row["chosen"]);
            $town = strval($row["town"]);
    
            $info += ["chosen" => $chosen];
            $info += ["location_id" => $location_id];
            $info += ["address" => $address];
            $info += ["country" => $country];
            $info += ["postcode" => $postcode];
            $info += ["city" => $city];
            $info += ["town" => $town];
            array_push($infos,$info);}
    echo json_encode($infos);}
    else{echo "failed";}
?>