var Bignumber=0;
function render(seatNumber,lineNumber){
    //console.log(json);
    $.get('question/game',{seatNumber,lineNumber}, function(answer){ // Посылает запрос на сервер о том сколько клеток.
        option = JSON.parse(answer);
        if (typeof option.lvl === 'undefined') { console.log("NULL")};
        type = option.type;
        console.log(window.Bignumber);
        renderArena(option);
    });
}

function renderArena(option) 
{
    let rendertext = "";
    let state= "";
    document.querySelector("div.arena").innerHTML='';
    if((option.who_win == 0) || (option.who_win == 1) || (option.who_win == 3))
    {
        state=`<h1>`;
            if(option.who_win == 0)
            {
                state=state+`Победил компьютер!`;
            }
            else if(option.who_win == 1)
            {
                state=state+`Победил человек!`;
            }
            else
            {
                state=state+`Ничья!`;
            }
            state=state+`</h1>
            <ul><li><a href="/" '>Новая игра</a></li></ul>`;
            document.querySelector("div.state").innerHTML=state;
            window.Bignumber=1;
    }
    rendertext = `<div class="sector" data-sector-number="1">`;
    for(var y=1;y<=option.type;y++)
    {
        rendertext+=`<div class="sector__line" data-line-number=`+y+`>`;
        for(var x=1;x<=option.type;x++)
        {
            var number=y*10+x;
            if(option.win != null && option.win !=0)
            {
                win=option.win;
                win=win.split(",");
                console.log(win.length);
                for(var n=0;n<win.length;n++)
                {
                    if(win[n] == number) 
                    {
                        rendertext+=`<div class="sector__seat__red" data-seat-number=`+x+`>`;
                        //number=0;
                        for(var n=0;n<move_1.length;n++)
                    {
                        if(move_1[n] == number) 
                        {
                            rendertext+=`<img src="jpg/Group 7.svg" alt="Круг">`;
                            n=15;
                            number=0;
                        }
                    }
                    //
                    for(var n=0;n<move_2.length;n++)
                    {
                        if(move_2[n] == number) 
                        {
                            rendertext+=`<img src="jpg/Group 6.svg" alt="Крест">`;
                            n=15;
                            number=0;
                        }
                    }
                    n=15;
                    number=0;
                    }
                }
            }
            if(number !=0) rendertext+=`<div class="sector__seat" data-seat-number=`+x+`>`;
                if(option.move_1 != null)
                {
                    move_1=option.move_1;
                    move_1=move_1.split(",");
                    move_2=option.move_2;
                    move_2=move_2.split(",");
                    //
                    for(var n=0;n<move_1.length;n++)
                    {
                        if(move_1[n] == number) 
                        {
                            rendertext+=`<img src="jpg/Group 7.svg" alt="Круг">`;
                            n=15;
                            number=0;
                        }
                    }
                    //
                    for(var n=0;n<move_2.length;n++)
                    {
                        if(move_2[n] == number) 
                        {
                            rendertext+=`<img src="jpg/Group 6.svg" alt="Крест">`;
                            n=15;
                            number=0;
                        }
                    }

                }
            rendertext+=`</div>`;
        }
        rendertext+=`</div>`;
    }
    rendertext+=`</div>`;
    //document.querySelector("div.state").innerHTML=state;
    document.querySelector("div.arena").innerHTML=rendertext;
}

const handleSeatSelect = e => {

    if ((e.target.hasAttribute('data-seat-number')) && (window.Bignumber == 0)) {
        const seatNumber = e.target.getAttribute('data-seat-number');
        const lineNumber = e.target.closest('.sector__line').getAttribute('data-line-number');
        const sectorNumber = e.target.closest('.sector').getAttribute('data-sector-number');
        render(seatNumber,lineNumber);
        const selectedSeatElem = document.querySelector('.board__selected-seat');

    }
};

const initHandlers = () => {
    const arenaElem = document.querySelector('.arena');
    arenaElem.addEventListener('click', handleSeatSelect);
};

document.addEventListener('DOMContentLoaded', () => {
    render();
    initHandlers();
});
