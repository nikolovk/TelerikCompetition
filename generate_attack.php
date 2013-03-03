<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'class/Calculations.php';
include 'inc/db.php';
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
            } else {
                $positionError = true;
                break;
            }
        } else {
            $price += 1 * $value['1'];
            $x = $value['2'];
            $y = $value['3'];
            if ($taken[$x][$y] == null) {
                $taken[$x][$y] = true;
                $list[] = array($value['1'], $x, $y, 'chicken');
            } else {
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


        // BOMB calculations
        $damages = 0;
        $money = 200;
        $bestResult = 0;
        $defense = $_SESSION['defense'];
        // Search bomb position
        for ($x = 0; $x <= 100; $x++) {
            for ($y = 0; $y <= 100; $y++) {
                for ($radius = 0; $radius < 20; $radius++) {
                    $result = Calculations::DamagesInRadius($x, $y, $radius, $defense);
                    $coef = $result / (10 + $radius * 2);
                    if ($coef > $bestResult) {
                        $topResult = $result;
                        $bestResult = $coef;
                        unset($bestBomb);
                        $bestBomb = array('bomb', $radius, $x, $y);
                    }
                }
            }
        }
        //echo $topResult;
        $damages += $topResult;
        $money -= (10 + 10 * $bestBomb['1']);
        $hitted[] = Calculations::DestroyInRadius($bestBomb['2'], $bestBomb['3'], $bestBomb['1'], $defense);
        $bestList[] = $bestBomb;
        while ($money > 6 && count($defense) > 0) {
            $bestResult = 0;
            $maxPigs = floor($money / 7);
            foreach ($defense as $key => $value) {
                $bestPigs = array();
                $result = 0;
                $coef = 0;
                $elementX = $value['1'];
                $elementY = $value['2'];
                for ($count = 1; $count <= $maxPigs; $count++) {
                    if (Calculations::PigsAttack($elementX, $elementY, $count, $defense)) {
                        $result = Calculations::DamagesInRadius($elementX, $elementY, 1.5, $defense);
                        $coef = $result / ($count * 7);
                        if ($coef > $bestResult) {
                            $bestResult = $coef;
                            $bestPigs = array('pigs', $count, $elementX, $elementY);
                            break 2;
                        }
                    }
                }
            }
            if ($result > 0) {
                $damages += $result;
                $money -=($bestPigs[1] * 7);
                $bestList[] = $bestPigs;
                $hit = Calculations::DestroyInRadius($bestPigs['2'], $bestPigs['3'], 1.5, $defense);
                $hitted = array_merge((array) $hitted, (array) $hit);
            } else {
                break;
            }
        }
        $hitted = array_unique($hitted);
        if (!Calculations::searchForId('mine', $defense)) {
            $damages *= 2;
        }
        $rs = $db->query("SELECT id FROM attack WHERE result < $damages");
        if ($rs->rowCount() < 15) {
            $data['fame'] = true;
            $_SESSION['bestDefense'] = $damages;
        }
        $data['hitted'] = $hitted[0];
        $data['attack'] = $bestList;
        $data['result'] = $damages;
        echo json_encode($data);
    }
}
?>