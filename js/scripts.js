/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    //    $('li#mine, li#chickens').click(function() {
    //        $('li').removeClass('selected');
    //        $(this).addClass('selected');
    //    });
    
    
    // When clicking on the button close or the mask layer the popup closed
    $('a.close, #mask').bind('click', function() {
        $('#mask , #popup, #message').fadeOut(300, function() {
            $('#mask').remove();
        });
        return false;
    });
});
function CalculateAttack(){
    $.getJSON('calculate_attack.php?', {
        'list':$('#attack p').html()
    }, function(data){
        if (data.priceError) {
            alert(data.priceError);
        } 
        if (data.bombError != null) {
            alert(data.bombError);
        }
        if (!data.errorBomb && !data.priceError && data.list) {
            $.each(data.list, function(key, value) {
                $('#table td#'+value+' img.attack').remove();
                $('#table td#'+value).append('<img src="images/x.png" width="29" height="29" class="x" />');
            });   
            $('#calculate').attr('disabled', 'disabled');
            $('#table td').removeAttr('onclick');
            ShowMessage('Your score: ' + data.result);
            var page = window.location.pathname;
            if (data.fame && page== '/attack.php') {
                $('#message p').append('<br />');
                $('#message p').append('Great result!<br />');
                $('#message p').append('Please, insert your name:<br />');
                $('#message p').append('<input type="text" name="fame_attack" id="fame_attack" /><br />');
                $('#message p').append('<a href="#" onclick="AttackToFame()" class="submit">Save</a><br />');                
            }
        }
    });
}

function AttackToFame(){
    $.getJSON('inc/attack_to_fame.php', {
        'name':$('#fame_attack').val()
    }, function(){
        ShowMessage('Your result was added in Hall of Fame');
    });
}

function DefenseToFame(){
    $.getJSON('inc/defense_to_fame.php', {
        'name':$('#fame_defense').val()
    }, function(){
        ShowMessage('Your result was added in Hall of Fame');
    });
}

function PlayInDefense (){
    //UploadDefense();
    //alert('');
    GenerateAttack();
}

function GenerateAttack(){ 
    var text = $('#defense p').html();
    ShowMessage('Calculate attack!<br />Please wait!');
    $.getJSON('generate_attack.php',  {
        'text':text
    }, function (data){
        if (data) {
            $.each(data.hitted, function(key,value){
                $('#table td#'+value).append('<img src="images/x.png" width="29" height="29" class="x" />');
            });
            $.each(data.attack, function(key,value){
                $('#'+value[2]+'_'+value[3]).addClass('defense');
                if (value[0] == 'bomb') {
                    $('#'+value[2]+'_'+value[3]).append('<img src="images/bomb.png" width="29" height="29" />');
                    $('#attack p').append('bomb' + ' ' + value[1] + ' '+ value[2] + ' ' + value[3] + '<br />');
                }else {
                    $('#'+value[2]+'_'+value[3]).append('<img src="images/pig.png" width="29" height="29" />');
                    $('#attack p').append('pigs' + ' ' + value[1] + ' '+ value[2] + ' ' + value[3] + '<br />');
                }
                $('#'+value[2]+'_'+value[3]+' span').remove();
                $('#'+value[2]+'_'+value[3]).append('<span>'+value[1].toString()+'</span>');
            });
            $('#play').attr('disabled', 'disabled');
            $('#table td').removeAttr('onclick');
            ShowMessage('Your score: ' + data.result);
            var page = window.location.pathname;
                var money = parseInt($('#money span').html());
            if (data.fame && page== '/defense.php' && money ==0) {
                $('#message p').append('<br />');
                $('#message p').append('Great result!<br />');
                $('#message p').append('Please, insert your name:<br />');
                $('#message p').append('<input type="text" name="fame_defense" id="fame_defense" /><br />');
                $('#message p').append('<a href="#" onclick="DefenseToFame()" class="submit">Save</a><br />');
            }
        }
    });
}


function UploadDefense() {
    var text = $('#defense p').html();
    $.getJSON('upload_defense.php?', {
        'text':text
    }, function(data){
        if (data) {
        //alert('Defense uploaded!');
        } else {
        //alert('Defense problem!');
        }
    });
}
function InputDefense(){
    UploadDefense();
    $('aside li.selected').removeClass();
    $('#count').html('Count<span>1</span>');
    $('#money').html('Money<span>200</span>');   
    $('aside').removeData('id');
    $('aside').attr('id', 'multi_attack');
}


function GenerateDefense(){
    ClearField();
    $('.commands').empty();
    $('aside li.selected').removeClass();
    $('#count').html('Count<span>1</span>');
    $('#money').html('Money<span>200</span>');
    $('aside').removeClass();
    $.getJSON("generate.php?",
        function(data){
            if (data) {
                $.each(data, function(key,value) {
                    $('#'+value[1]+'_'+value[2]).addClass('defense');
                    if (value[3] == 'chicken') {
                        $('#'+value[1]+'_'+value[2]).html('<img src="images/chicken.png" width="29" height="29" />');
                        $('#defense p').append('chickens' + ' ' + value[0] + ' '+ value[1] + ' ' + value[2] + '<br />');
                    }else {
                        $('#'+value[1]+'_'+value[2]).html('<img src="images/mine.png" width="29" height="29" />');
                        $('#defense p').append('mine' + ' '+ value[1] + ' ' + value[2] + '<br />');
                    }
                    $('#'+value[1]+'_'+value[2]).append('<span>'+value[0].toString()+'</span>');
                });   
            }
        });
}
function ClearField(){
    $('#calculate').removeAttr('disabled');
    $("#table td").each(function(){
        $(this).removeClass();
        $(this).empty();
    });
}

function SelectMine() {
    $('li').removeClass('selected');
    $('#mine').addClass('selected');
    $('#count').html('Count<span>1</span>');
}
function SelectChickens() {
    $('li').removeClass('selected');
    $('#chickens').addClass('selected');
    $('#count').html('Count<span>1</span>');
    EditCount();
}
function SelectBomb() {
    var bombed = $('aside').hasClass('bombed');
    if (bombed) {
        alert('You can use only one bomb!');
    } else {
        $('li').removeClass('selected');
        $('#bomb').addClass('selected');
        $('#count').html('Radius<span>0</span>');
        EditCount();
    }
}
function SelectPigs() {
    $('li').removeClass('selected');
    $('#pigs').addClass('selected');
    $('#count').html('Count<span>1</span>');
    EditCount();

}


function ClosePopup() {
    $('#mask , #popup, #message').fadeOut(300, function() {
        $('#mask').remove();
    });
}

function ShowMessage(msg){
    //Fade in the Popup
    $("#message").fadeIn(300);
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    $('#message p').html(msg);
}

function EditCount() {
    var type = $('aside li.selected').attr('id');
    if (type == 'chickens' || type == 'bomb'|| type == 'pigs') {
        var count = $("#count span").html();
        $('#popup_count').val(count);
        
        //Fade in the Popup
        $("#popup").fadeIn(300);
        // Add the mask to body
        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);
    } else{
        alert('Must choose element before change value!');
    }

}

function ChangeCount() {    
    var money = parseInt($('#money span').html());
    var value = parseInt($('#popup_count').val());
    var type = $('aside li.selected').attr('id');
    var price = 0;
    switch (type) {
        case 'pigs':
            price = value*7;
            break;
        case 'bomb':
            price = value*10 + 10;
            break;
        case 'mine':
            price = 6;
            break;
        case 'chickens':
            price = value;
            break;
        default:
            break;
    }
    if (price > money) {
        alert('You don\'t have enough money!');
    } else {
        $('#count span').html(value);
        ClosePopup();
    }
}

function PutObject(x,y){
    var count = parseInt($("#count span").html());
    var money = parseInt($('#money span').html());
    var type = $('aside li.selected').attr('id');
    var isDefense = $('#'+x+'_'+y).hasClass('defense');
    var isAttack = $('#'+x+'_'+y).hasClass('attack');
    var price = 0;
    if (((type == 'pigs' || type=='bomb') && isAttack) ||
        ((type == 'chickens' || type=='mine') && isDefense)){
        alert('Field allready taken!')
    } else {
        switch (type) {
            case 'mine':
                price = 6;
                break;
            case 'chickens':
                price = count;
                break;
            case 'bomb':
                price = 10+10*count;
                break;
            case 'pigs':
                price = 7*count;
                break;
            
            default:
                break;
        }
        
        if (money >= price) {
            switch (type) {
                case 'chickens':
                    $('#'+x+'_'+y).addClass('defense');
                    $('#'+x+'_'+y).html('<img src="images/chicken.png" width="29" height="29" class="defense" />');
                    $('#money span').html(money - count);
                    $('#defense p').append('chickens' + ' ' + count + ' '+ x + ' ' + y + '<br />');
                    $('#'+x+'_'+y).append('<span>'+count+'</span>');
                    break;
                case 'mine':
                    $('#'+x+'_'+y).addClass('defense');
                    $('#'+x+'_'+y).html('<img src="images/mine.png" width="29" height="29" class="defense" />');
                    $('#money span').html(money - 6);
                    $('#defense p').append('mine' + ' ' + x + ' ' + y + '<br />');
                    $('#'+x+'_'+y).append('<span>'+count+'</span>');
                    break;
                case 'pigs':
                    $('#'+x+'_'+y+' span').remove();
                    $('#'+x+'_'+y).addClass('attack');
                    $('#'+x+'_'+y).append('<img src="images/pig.png" width="29" height="29" class="attack" />');
                    $('#money span').html(money - count*7);
                    $('#attack p').append('pigs' + ' ' + count + ' '+ x + ' ' + y + '<br />');
                    $('#'+x+'_'+y).append('<span>'+count+'</span>');
                    break;
                case 'bomb':
                    $('#'+x+'_'+y+' span').remove();
                    $('#'+x+'_'+y).addClass('attack');
                    $('#'+x+'_'+y).append('<img src="images/bomb.png" width="29" height="29" class="attack" />');
                    $('#money span').html(money - 10 - 10*count);
                    $('#attack p').append('bomb' + ' ' + count + ' ' + x + ' ' + y + '<br />');
                    $('#'+x+'_'+y).append('<span>'+count+'</span>');
                    $('li').removeClass('selected');
                    $('#pigs').addClass('selected');
                    $('#count').html('Count:<span>1</span>');
                    $('aside').addClass('bombed');
                    break;
                default:
                    alert('Please choose element');
                    break;
            }
        } else {
            alert('You don\'t have enough money!')
        }
    }
}
