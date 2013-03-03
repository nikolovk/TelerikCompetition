<?php include 'inc/header.php'; ?>
<section>
    <p>First build defense. Press To Attack, and build attack. When you are ready, you can see result.</p> 
    <div id="table">
        <?php include 'inc/table.php'; ?> 
    </div>
</section>
<aside id="multi_defense">
    <button id="to_attack" onclick="InputDefense()">Finish Defense</button>
    <button id="calculate" onclick="CalculateAttack()">Calculate</button>
    <div id="defense_input">
        <h2>Choose element</h2>
        <ul>
            <li id="mine" onclick="SelectMine()">Mine<img src="images/mine.png" width="29" height="29" /></li>
            <li id="chickens" onclick="SelectChickens()">Chickens<img src="images/chicken.png" width="29" height="29" /></li>

            <li id="bomb" onclick="SelectBomb()">Bomb<img src="images/bomb.png" width="29" height="29" /></li>
            <li id="pigs" onclick="SelectPigs()">Pigs<img src="images/pig.png" width="29" height="29" /></li>
            <li id="count" onclick="EditCount()">Count<span>1</span></li>
            <li id="money">Money<span>200</span></li>
        </ul>
    </div>
    <div id="defense" class="text">
        <h2>Defense</h2>
        <p class="commands"></p>
    </div>
    <div id="attack" class="text">
        <h2>Attack</h2>
        <p class="commands"></p>
    </div>
</aside>
<?php include 'inc/footer.php'; ?>