function zatw(){
    var checked = document.querySelectorAll('input[type="checkbox"]:checked');
    var unchecked = document.querySelectorAll('input[type="checkbox"]:not(:checked)');
    var head = "";
    var i = 1;
    
    checked.forEach(element => {
        head = head+'src'+i+'='+element.name+'&';
        i +=1;
    })

    i=1;
    unchecked.forEach(element => {
        head = head+'usrc'+i+'='+element.name+'&';
        i +=1;
    })
    
    var link = '/remember?' + head;
    location.assign(link);
}

function usunZaz(){
    var checked = document.querySelectorAll('input[type="checkbox"]:checked');
    var head="";
    var i = 1;
    checked.forEach(element => {
        head = head+'usrc'+i+'='+element.name+'&';
        i +=1;
    })
    var link = '/remember?' + head;
    location.assign(link);
}