<?php include 'inc/header.php'; ?>
<section>
    <p>You can use bomb and pigs to attack this random field.</p> 
    <div id="table">
        <?php include 'inc/table.php'; ?> 
    </div>
</section>
<aside>
    <button id="calculate" onclick="CalculateAttack()">Calculate</button>
    <div id="defense_input">
        <h2>Choose element</h2>
        <ul>
            <li id="bomb" onclick="SelectBomb()">Bomb<img src="images/bomb.png" width="29" height="29" /></li>
            <li id="pigs" onclick="SelectPigs()">Pigs<img src="images/pig.png" width="29" height="29" /></li>
            <li id="count" onclick="EditCount()">Count<span>1</span></li>
            <li id="money">Money<span>200</span></li>
        </ul>
    </div>
    <div id="defense" class="text">
        <h2>Defense</h2>
        <p class="commands"></p>
        <button id="generate" onclick="GenerateDefense()">New Game</button>
    </div>
    <div id="attack" class="text">
        <h2>Attack</h2>
        <p class="commands"></p>
    </div>
</aside>
<script>
    GenerateDefense();
</script>
<?php include 'inc/footer.php';?>