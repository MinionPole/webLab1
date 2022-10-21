let yField;

function init(){
    yField = document.getElementById('yInputIdField');
}

function isNumber(s) {
    let n = Number(s.replace(',','.'));
    return !isNaN(n) && isFinite(n);
}

function genError(error){
    alert(error);
}

function yCheck(coordinate, min, max){
    if(coordinate.value){
        if(!isNumber(coordinate.value) || Number(coordinate.value) < min || Number(coordinate.value) > max)
            genError("некорректное значение");
        else
            return true;
    }
    else{
        genError("поле пусто");
    }
}

function radioCheck(){
    let rad=document.getElementsByName('X');
    for (let i=0;i<rad.length; i++) {
        if (rad[i].checked) {
            return true;
        }
    }
    genError("поле пусто");
    return false;
}

function getX(){
    let rad=document.getElementsByName('X');
    for (let i=0;i<rad.length; i++) {
        if (rad[i].checked) {
            return rad[i].value;
        }
    }
}

function getR(){
    let tick = document.getElementsByName('R');
    for (let i=0;i<tick.length; i++) {
        if (tick[i].checked) {
            return tick[i].value;
        }
    }
}

function tickCheck(){
    let tick = document.getElementsByName('R');
    let counter = 0;
    for (let i=0;i<tick.length; i++) {
        if (tick[i].checked) {
            counter = counter + 1;
        }
    }
    if(counter != 1){
        genError("выбрано слишком много полей");
    }
    return counter == 1;
}

$(document).ready(function(){

    $("#parInForm").on("submit", function(event){
        event.preventDefault();
        init();
        let iscorrect = true;
        iscorect = iscorrect && tickCheck();
        iscorect = iscorrect && radioCheck();
        iscorect = iscorrect && yCheck(yField, -3, 3);
        console.log("данные отправляются" );
        console.log($(this).serialize());
        if(iscorect){
            $.ajax({
                url: 'php/test.php',
                method: 'post',
                dataType: 'html',
                data: $(this).serialize() + "&startTime=" + new Date().getTimezoneOffset(),
                success: function(data){
                    console.log(data);
                    $("#footerSite").html(data);
                }
            });
        }
        
    });
});

