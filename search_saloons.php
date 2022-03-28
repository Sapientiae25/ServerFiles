<?php
if (isset($_POST['text'])){
    require_once 'conn.php';

    $text = $_POST['text'];
    
    $sql = "SELECT name,account_id FROM account WHERE name LIKE '%".$text."%' ORDER BY RAND() LIMIT 8";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $saloons = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();
        $info += ["name" => strval($row["name"])];
        $info += ["id" => strval($row["account_id"])];

        array_push($saloons,$info);}

    echo json_encode($saloons);}
    else{echo "failed";}
?>