<?php
    if (isset($_POST['location_id']) && isset($_POST['address']) && isset($_POST['postcode']) && isset($_POST['country'])
     && isset($_POST['city']) && isset($_POST['town'])){
        require_once 'conn.php';

        $location_id = $_POST['location_id'];
        $address = $_POST['address'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $town = $_POST['town'];

        $sql = "UPDATE saved_locations SET address = ?, postcode = ?, country = ?, city = ?, town = ? WHERE location_id = ?";

        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ssssss",$address,$postcode,$country,$city,$town,$location_id);
        $stmt->execute();}
    else{echo "failed";}
?>