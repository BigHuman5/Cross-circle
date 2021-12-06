let option;
function broadCast(type,lvl)
{    
    console.log(type);
    console.log(lvl);
    $.get('question/main', {type,lvl}, function(answer){
        //console.log(answer.lvl);
    });
}

$('a').click(function(){
    option = $(this).attr('options');
    option = JSON.parse(option);
    var type = option.type;
    var lvl = option.lvl;
    broadCast(type,lvl);
    //console.log(option);
});