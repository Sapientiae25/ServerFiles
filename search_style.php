<?php
if (isset($_POST['text'])){
    require_once 'conn.php';

    $text = $_POST['text'];
    
    $sql = "SELECT name,COUNT(*) AS size FROM style WHERE name LIKE '%".$text."%' GROUP BY name ORDER BY size DESC";

    $stmt= $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $styles = array();

    while($row = mysqli_fetch_assoc($result)) {array_push($styles,strval($row["name"]));}

    echo json_encode($styles);}
    else{echo "failed";}
?>