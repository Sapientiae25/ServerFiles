<?php
if (isset($_POST['user_fk'])){
    require_once 'conn.php';

    $user_fk = $_POST['user_fk'];
    
    $sql = "SELECT style_fk,st.name FROM viewed
        INNER JOIN style AS st ON st.style_id = style_fk
        WHERE user_fk = ? ORDER BY view_date";

    $stmt= $conn->prepare($sql);
    $stmt->bind_param("i", $user_fk);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $infos = array();

    while($row = mysqli_fetch_assoc($result)) {
        $info = array();

        $info += ["style_fk" => strval($row["style_fk"])];
        $info += ["name" => strval($row["name"])];
        array_push($infos,$info);
    }
    echo json_encode($infos);}
    else{echo "failed";}
?>