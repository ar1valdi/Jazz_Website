window.onload = function() {
    if (window.localStorage) {
        var licznik = document.getElementById("licznik");

        if (licznik != null)
            licznik.style.display = 'block';

        if (localStorage.odwiedziny)
            localStorage.odwiedziny = Number(localStorage.odwiedziny) + 1;
        else
            localStorage.odwiedziny = 1;

        var text = document.createTextNode("Odwiedziłeś tę stronę " + localStorage.odwiedziny + " razy");
        document.getElementById('tuWpisz').appendChild(text);
    }
}