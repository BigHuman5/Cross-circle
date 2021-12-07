let option;
function broadCast(type,lvl)
{    
    $.get('question/main', {type,lvl}, function(answer){});
}

$('a').click(function(){
    option = $(this).attr('options');
    option = JSON.parse(option);
    var type = option.type;
    var lvl = option.lvl;
    broadCast(type,lvl);
});