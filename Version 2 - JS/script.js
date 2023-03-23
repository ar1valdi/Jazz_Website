window.onload = function () {
    var button = document.createElement('button');
    button.type = 'button';
    button.onclick = przywroc;
    var text = document.createTextNode('Przywróć');
    button.appendChild(text);
    document.getElementById('nowyGuzik').appendChild(button);
}

function changeColor() {
    var thingToChange = document.getElementById('zmianaKoloru');
    thingToChange.style.color = 'lightgrey';
}

function changeColorBack() {
    var thingToChange = document.getElementById('zmianaKoloru');
    thingToChange.style.color = 'white';
}

function zapamietaj() {
    if (window.sessionStorage) {
        var sprawdz = document.querySelector('input[name="plec"]:checked');

        if (sprawdz != null) {
            var formData = {
                'imie': document.getElementById('imie').value,
                'nazwisko': document.getElementById("nazwisko").value,
                'plec': document.querySelector('input[name="plec"]:checked').value,
                'poziom': document.getElementById("stan").value,
                'email': document.getElementById("email").value,
                'telefon': document.getElementById("tel").value,
                'plik': document.getElementById("plik").value,
                'msg': document.getElementById("msg").value
            }

            toJson = JSON.stringify(formData);
            sessionStorage.dane = toJson;
            console.log(sessionStorage.dane);
        }
        else {
            var formData = {
                'imie': document.getElementById('imie').value,
                'nazwisko': document.getElementById("nazwisko").value,
                'poziom': document.getElementById("stan").value,
                'email': document.getElementById("email").value,
                'telefon': document.getElementById("tel").value,
                'plik': document.getElementById("plik").value,
                'msg': document.getElementById("msg").value
            }

            toJson = JSON.stringify(formData);
            sessionStorage.dane = toJson;
            console.log(sessionStorage.dane);
        }
    }
}

function przywroc() {
    if (window.sessionStorage && sessionStorage.dane) {
        var formData = JSON.parse(sessionStorage.dane);
        document.getElementById('imie').value = formData.imie;
        document.getElementById('nazwisko').value = formData.nazwisko;

        var plecRadio = document.querySelectorAll('input[name="plec"]');
        for (let i = 0; i < plecRadio.length; i++) {
            if (plecRadio[i].value === formData.plec)
                plecRadio[i].checked = true;
        }

        document.getElementById('stan').value = formData.poziom;
        document.getElementById('email').value = formData.email;
        document.getElementById('tel').value = formData.telefon;
        document.getElementById('plik').value = formData.plik;
        document.getElementById('msg').value = formData.msg;
    }
}


window.onunload = zapamietaj;