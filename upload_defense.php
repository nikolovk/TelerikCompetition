<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$money = 200;
$price = 0;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $text = trim($_REQUEST['text']);
    $defense = array_filter(explode('<br>', $text), 'strlen');
    foreach ($defense as $line) {
        $value = explode(' ', $line);
        $type = $value['0'];
        if ($type == 'mine') {
            $price += 6;
            $x = $value['1'];
            $y = $value['2'];
            if ($taken[$x][$y] == null) {
                $taken[$x][$y] = true;
                $list[] = array(1, $x, $y, 'mine');
            } else{
                $positionError = true;
                break;
            }
        } else {
            $price += 1*$value['1'];
            $x = $value['2'];
            $y = $value['3'];
            if ($taken[$x][$y] == null) {
                $taken[$x][$y] = true;
                $list[] = array($value['1'], $x, $y, 'chicken');
            } else{
                $positionError = true;
                break;
            }
        }
    }
    if ($price > $money) {
        $moneyError = true;
    }
    if ($moneyError || $positionError) {
        echo false;
    } else {
        $_SESSION['defense'] = $list;
        echo true;
    }
}