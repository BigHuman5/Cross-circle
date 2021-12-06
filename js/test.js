let params = (new URL(document.location)).searchParams; 
var type = params.get("type");
var lvl = params.get("lvl");

$.get('question', {type,lvl}, function(answer){

    answer = JSON.parse(answer);
    console.log(answer.lvl);
});