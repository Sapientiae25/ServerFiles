<?php
    if (isset($_POST['user_id'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];

        $sql = "SELECT location_id,address,longitude,latitude,postcode FROM saved_locations
            WHERE user_fk = ? AND chosen = 1";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $infos = array();
    
        while($row = mysqli_fetch_assoc($result)) {
            $info = array();
            $latitude = strval($row["latitude"]);
            $longitude = strval($row["longitude"]);
            $address = strval($row["address"]);
            $postcode = strval($row["postcode"]);
            $location_id = strval($row["location_id"]);
    
            $info += ["location_id" => $location_id];
            $info += ["address" => $address];
            $info += ["longitude" => $longitude];
            $info += ["postcode" => $postcode];
            $info += ["latitude" => $latitude];
            array_push($infos,$info);}
    echo json_encode($infos);}
    else{echo "failed";}
?>