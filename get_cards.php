<?php
if (isset($_POST['user_fk'])){
    require_once 'conn.php';

    $user_fk = $_POST['user_fk'];
    
    $sql = "SELECT * FROM payment WHERE user_fk = ?";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("i", $user_fk);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $infos = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();

        $info += ["card_number" => strval($row["card_number"])];
        $info += ["cvv" => strval($row["cvv"])];
        $info += ["expiry" => strval($row["expiry"])];
        $info += ["card_id" => strval($row["card_id"])];

        array_push($infos,$info);
    }
    echo json_encode($infos);}
    else{echo "failed";}
?>