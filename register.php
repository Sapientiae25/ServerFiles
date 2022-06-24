<?php
    if (isset($_POST['city']) && isset($_POST['country']) && isset($_POST['postcode']) && isset($_POST['latitude'])
     && isset($_POST['address']) && isset($_POST['longitude']) && isset($_POST['town']) && isset($_POST['name'])
      && isset($_POST['password']) && isset($_POST['email'])){
        require_once 'conn.php';

        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];
        $address = $_POST['address'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $town = $_POST['town'];

        $sql = "INSERT INTO account (name, password, email, number, open, close) VALUES (?,?,?,null,'06:00:00','21:00:00')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $password, $email);
        $stmt->execute();
        $account_id = strval(mysqli_insert_id($conn));
        
        $sql = "INSERT INTO address (city, postcode, country, address, latitude, longitude, town) VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdds", $city, $postcode, $country, $address, $latitude, $longitude, $town);
        $stmt->execute();
        $addres_fk = strval(mysqli_insert_id($conn));

        $sql = "INSERT INTO address_jnct (address_fk, account_fk) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $addres_fk, $account_id);
        $stmt->execute();

        echo $account_id;
    }else{echo "failed";}
?>