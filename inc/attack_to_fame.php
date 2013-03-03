<?php


include '../inc/db.php';
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $name = trim($_REQUEST['name']);
    echo $_SESSION['bestAttack'];
    $stmt = $db->prepare('INSERT INTO `attack`(`name`, `result`) VALUES (:name,:result)');
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':result',$_SESSION['bestAttack']);
    $added = $stmt->execute();
    echo $added;
}
