<table>

    <?php
    for ($y = 100; $y >= 0; $y--) {
        echo '<tr>';
        for ($x = 0; $x <= 100; $x++) {
            echo '<td id="' . $x . '_' . $y . '" title="x=' . $x . ' y=' . $y . '" onclick="PutObject(' . $x . ',' . $y . ')"></td>';
        }
        echo '</tr>';
    }
    ?>
</table>
