<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calculations
 *
 * @author krasi
 */
class Calculations {

    public static function InRange($x1, $y1, $x2, $y2, $radius) {
        $dx = $x1 - $x2;
        $dy = $y1 - $y2;
        if ($radius * $radius >= $dx * $dx + $dy * $dy) {
            return true;
        } else {
            return false;
        }
    }

    public static function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['3'] == $id) {
                return true;
            }
        }
        return false;
    }

    public static function DamagesInRadius($x, $y, $radius, $defense) {
        $price = 0;
        foreach ($defense as $value) {
            $count = $value['0'];
            $elementX = $value['1'];
            $elementY = $value['2'];
            $type = $value['3'];
            $inRange = self::InRange($x, $y, $elementX, $elementY, $radius);
            if ($inRange) {
                if ($type == 'mine') {
                    $price += 6;
                } else {
                    $price += 1 * $count;
                }
            }
        }
        return $price;
    }

    public static function DestroyInRadius($x, $y, $radius, &$defense) {
        foreach ($defense as $key => $value) {
            $elementX = $value['1'];
            $elementY = $value['2'];
            $inRange = self::InRange($x, $y, $elementX, $elementY, $radius);
            if ($inRange) {
                unset($defense[$key]);
                $hitted[] = $elementX . '_' . $elementY;
            }
        }
        return $hitted;
    }

    public static function PigsAttack($x, $y, $pigsCount, $defense) {
        $chickensCount = 0;
        foreach ($defense as $value) {
            $count = $value['0'];
            $elementX = $value['1'];
            $elementY = $value['2'];
            $type = $value['3'];
            $inRange = self::InRange($x, $y, $elementX, $elementY, 2);
            if ($inRange && $type == 'chicken') {
                $chickensCount += $count;
            }
        }
        if (2 * $pigsCount >= $chickensCount) {
            return true;
        } else {
            return false;
        }
    }

}

?>
