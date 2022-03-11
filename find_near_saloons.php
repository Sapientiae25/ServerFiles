<?php
if (isset($_POST['lat']) && isset($_POST['long'])){
    require_once 'conn.php';

    $lat = $_POST['lat'];
    $long = $_POST['long'];
    
    $sql = "SELECT acc.account_id,ad.address_id,acc.name,ad.address,date_format(acc.close,'%H:%i') AS close,
    date_format(acc.open,'%H:%i') AS open,ad.postcode,ad.latitude,ad.longitude, ROUND(SQRT(POW(69.1 * (latitude - ?), 2) +
        POW(69.1 * (? - longitude) * COS(latitude / 57.3), 2))*1.609, 2) AS distance
    FROM address_jnct as jnct
    INNER JOIN address as ad ON ad.address_id = jnct.address_fk
    INNER JOIN account as acc ON acc.account_id = jnct.account_fk
    ORDER BY distance LIMIT 15";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("dd", $lat,$long);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $infos = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();
        $account_id = strval($row["account_id"]);
        $sql = "SELECT AVG(rating) as rating FROM saloon_reviews WHERE account_fk = ?" ;
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $res = $stmt->get_result(); 
        $rating = "";
        while($row2 = mysqli_fetch_assoc($res)) { $rating = strval($row2["rating"]);}
        if (strlen($rating) == 0){$rating = "0.0";}

        $info += ["rating" => $rating];
        $name = strval($row["name"]);
        $address_id = strval($row["address_id"]);
        $address = strval($row["address"]);
        $close = strval($row["close"]);
        $open = strval($row["open"]);
        $postcode = strval($row["postcode"]);
        $longitude = strval($row["longitude"]);
        $latitude = strval($row["latitude"]);
        $distance = strval($row["distance"]);

        $info += ["distance" => $distance];
        $info += ["name" => $name];
        $info += ["address" => $address];
        $info += ["close" => $close];
        $info += ["rating" => $rating];
        $info += ["open" => $open];
        $info += ["postcode" => $postcode];
        $info += ["account_id" => $account_id];
        $info += ["address_id" => $address_id];
        $info += ["latitude" => $latitude];
        $info += ["longitude" => $longitude];
        array_push($infos,$info);
    }
    echo json_encode($infos);}
    else{echo "failed";}
?>