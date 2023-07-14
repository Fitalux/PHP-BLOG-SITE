<?php
    include "../connect/connect.php";
    
    $blogID = $_POST['blogID'];
    $memberID = $_POST['memberID'];
    $commentName = $_POST['name'];
    $commentPass = $_POST['pass'];
    $commentWrite = $_POST['msg'];
    $regTime = time();

    $sql = "INSERT INTO blogcomment(memberID, blogID, commentName, commentPass, commentMsg, commentDelete, regTime) 
    VALUES ('$memberID','$blogID','$commentName','$commentPass','$commentWrite','0','$regTime')";

    $result = $connect -> query($sql);

    echo json__encode(array("info" => $blogID));
?>