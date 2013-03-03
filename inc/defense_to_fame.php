<?php


include '../inc/db.php';
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $name = trim($_REQUEST['name']);
    $stmt = $db->prepare('INSERT INTO `defense`(`name`, `result`) VALUES (:name,:result)');
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':result',$_SESSION['bestDefense']);
    $added = $stmt->execute();
    echo $added;
}
