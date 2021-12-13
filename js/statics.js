function renderState(option)
{
    document.querySelector("div.computer3g").innerText = option['g3c'];
    document.querySelector("div.human3g").innerText = option['g3h'];
    document.querySelector("div.draw3g").innerText = option['g3d'];
    //
    document.querySelector("div.computer5g").innerText = option['g5c'];
    document.querySelector("div.human5g").innerText = option['g5h'];
    document.querySelector("div.draw5g").innerText = option['g5d'];
    //
    document.querySelector("div.computer7g").innerText = option['g7c'];
    document.querySelector("div.human7g").innerText = option['g7h'];
    document.querySelector("div.draw7g").innerText = option['g7d'];
    /**/
    document.querySelector("div.computer3y").innerText = option['y3c'];
    document.querySelector("div.human3y").innerText = option['y3h'];
    document.querySelector("div.draw3y").innerText = option['y3d'];
    //
    document.querySelector("div.computer5y").innerText = option['y5c'];
    document.querySelector("div.human5y").innerText = option['y5h'];
    document.querySelector("div.draw5y").innerText = option['y5d'];
    //
    document.querySelector("div.computer7y").innerText = option['y7c'];
    document.querySelector("div.human7y").innerText = option['y7h'];
    document.querySelector("div.draw7y").innerText = option['y7d'];
}

$.get('question/state',{}, function(answer){ // Посылает запрос на сервер
    option = JSON.parse(answer);
    renderState(option);
});