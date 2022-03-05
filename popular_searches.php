<?php
    require_once 'conn.php';
    
    $obj = array();
    
    $sql = "SELECT name FROM style ORDER BY RAND() LIMIT 5";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $styles = array();

    while($row = mysqli_fetch_assoc($result)) {array_push($styles,strval($row["name"]));}


    $sql = "SELECT name,account_id FROM account ORDER BY RAND() LIMIT 5";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $saloons = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();
        $info += ["name" => strval($row["name"])];
        $info += ["id" => strval($row["account_id"])];

        array_push($saloons,$info);}
    
    $obj += ["saloons" => $saloons];
    $obj += ["styles" => $styles];

    echo json_encode($obj);
?>