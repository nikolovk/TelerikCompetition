<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'class/Calculations.php';
include 'inc/db.php';
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $defense = $_SESSION['defense'];
    $result = 0;
    $price = 0;
    $bombed = false;
    $list = trim($_REQUEST['list']);
    $attacks = array_filter(explode('<br>', $list), 'strlen');
    foreach ($attacks as $line) {
        $value = explode(' ', $line);
        $attackX = $value['2'];
        $attackY = $value['3'];
        $type = $value['0'];
        if ($type == 'bomb') {
            if ($bombed) {
                $data['bombError'] = 'You can use only one bomb!';
                break;
            }
            $bombed = true;
            $radius = $value[1];
            $price += 10 + $radius * 10;
            foreach ($defense as $key => $line) {
                $defenseX = $line[1];
                $defenseY = $line[2];
                $typeDefense = $line[3];
                $countDefense = $line[0];
                $inRange = Calculations::InRange($attackX, $attackY, $defenseX, $defenseY, $radius);
                if ($inRange) {
                    $hitted[] = $defenseX . '_' . $defenseY;
                    if ($typeDefense == 'mine') {
                        $result += $countDefense * 6;
                    } else {
                        $result += $countDefense;
                    }
                    $defense[$key] = null;
                }
            }
        } else {
            $count = $value[1];
            $price += $count * 7;
            $countChickens = 0;
            foreach ($defense as $line) {
                $defenseX = $line[1];
                $defenseY = $line[2];
                $typeDefense = $line[3];
                $countDefense = $line[0];
                if ($typeDefense == 'chicken') {
                    $inRange = Calculations::InRange($attackX, $attackY, $defenseX, $defenseY, 2);
                    if ($inRange) {
                        $countChickens += $countDefense;
                    }
                }
            }
            if (2 * $count >= $countChickens) {
                foreach ($defense as $key => $line) {
                    $typeDefense = $line[3];
                    $defenseX = $line[1];
                    $defenseY = $line[2];
                    $countDefense = $line[0];
                    $inRange = Calculations::InRange($attackX, $attackY, $defenseX, $defenseY, 1.5);
                    if ($inRange) {
                        $hitted[] = $defenseX . '_' . $defenseY;
                        if ($typeDefense == 'mine') {
                            $result += $countDefense * 6;
                        } else {
                            $result += $countDefense;
                        }
                        $defense[$key] = null;
                    }
                }
            }
        }
    }
    if ($price > 200) {
        $data['priceError'] = 'You don\'t have money for this attack';
    }
    if (!Calculations::searchForId('mine', $defense)) {
        $result *= 2;
    }
    $rs = $db->query("SELECT id FROM attack WHERE result > $result");
    if ($rs->rowCount() < 15) {
        $data['fame'] = true;
        $_SESSION['bestAttack'] = $result;
    }
    $data['result'] = $result;
    $data['list'] = $hitted;
    echo json_encode($data);
}
?>
