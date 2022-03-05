<?php
    if (isset($_POST['city']) && isset($_POST['country']) && isset($_POST['postcode']) && isset($_POST['latitude'])
     && isset($_POST['address']) && isset($_POST['account_id']) && isset($_POST['longitude']) && isset($_POST['town'])){
        require_once 'conn.php';

        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $account_id = $_POST['account_id'];
        $address = $_POST['address'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $town = $_POST['town'];


        $sql = "UPDATE address SET city=?,postcode=?,country=?,address=?,latitude=?,longitude=?,town=? WHERE account_id =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiisi", $city, $postcode, $country, $address,$latitude,$longitude,$town,$account_id);
        $stmt->execute();
        
    }else{echo "failed";}
?>