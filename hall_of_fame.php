<?php include 'inc/header.php'; ?>
<section id="fame">
    <div id="attack_fame">
        <table>
            <caption>Best attacks</caption>
            <colgroup>
                <col class="place" />
                <col class="name" />
                <col class="result" />
            </colgroup>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Result</th>
            </tr>
            <?php
            $attacks = $db->query('SELECT name,result FROM attack ORDER BY result DESC LIMIT 15');
            if ($attacks->rowCount() > 0) {
                $place = 1;
                while ($row = $attacks->fetch()) {
                    echo '<tr>';
                    echo '<td>' . $place . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['result'] . '</td>';
                    echo '</tr>';
                    $place++;
                }
            }
            ?>
        </table>
    </div>
    <div id="defense_fame" class="clearfix">
        <table>
            <caption>Best defenses</caption>
            <colgroup>
                <col class="place" />
                <col class="name" />
                <col class="result" />
            </colgroup>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Result</th>
            </tr>
            <?php
            $defense = $db->query('SELECT name,result FROM defense ORDER BY result LIMIT 15');
            if ($defense->rowCount() > 0) {
                $place = 1;
                while ($row = $defense->fetch()) {
                    echo '<tr>';
                    echo '<td>' . $place . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['result'] . '</td>';
                    echo '</tr>';
                    $place++;
                }
            }
            ?>
        </table>
    </div>

</section>
<?php include 'inc/footer.php'; ?>