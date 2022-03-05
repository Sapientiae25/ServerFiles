<?php
    if (isset($_POST['user_id']) && isset($_POST['address']) && isset($_POST['postcode']) && isset($_POST['country'])
     && isset($_POST['city']) && isset($_POST['town']) && isset($_POST['latitude']) && isset($_POST['longitude'])){
        require_once 'conn.php';

        $user_id = $_POST['user_id'];
        $address = $_POST['address'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $town = $_POST['town'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        $sql = "INSERT INTO saved_locations (address,postcode,city,country,user_fk,town,latitude,longitude,chosen) 
        VALUES (?,?,?,?,?,?,?,?,1)";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ssssssss",$address,$postcode,$country,$city,$user_id,$town,$latitude,$longitude);
        $stmt->execute();
        $address_id = mysqli_insert_id($conn);
        $info = array();

        $info += ["address_id" => $address_id];
        echo json_encode($info);
    }
    else{echo "failed";}
?>