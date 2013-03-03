<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$money = 200;
$mines = rand(10, 20);
$money -= $mines * 6;
$chickenInGroup = floor($money / $mines);
for ($i = 1; $i <= $mines; $i++) {
    // mine position
    do {
        $mineX = rand(1, 99);
        $mineY = rand(1, 99);
    } while ($taken[$mineX][$mineY] == true);
    $taken[$mineX][$mineY] = true;
    $list[] = array(1, $mineX, $mineY,'mine');
    do {
        $add = rand(-1, 1);
        $chickenX = $mineX + $add;
        $add = rand(-1, 1);
        $chickenY = $mineY + $add;
    } while ($taken[$chickenX][$chickenY] == true);
    $taken[$chickenX][$chickenY] = true;
    $list[] = array($chickenInGroup, $chickenX, $chickenY, 'chicken');
    $money -= ($chickenInGroup);
}
while ($money > 0){
    $chickenX = rand(1, 99);
    $chickenY = rand(1, 99);
    if ($taken[$chickenX][$chickenY] != true) {
        $list[] = array(1, $chickenX, $chickenY, 'chicken');
        $money--;
    }
}
$_SESSION['defense'] = $list;
echo json_encode($list);
?>
