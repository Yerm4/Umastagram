let mayano = {
    nombre: "Mayano Top Gun",
    nacimiento: "24 de Marzo",
    altura: 1.43,
    cabello: "Naranja",
    estilos: "Front, Pace, Late, End",
    suelo: "Turf",
    distancia: "Medium, Long",
    rival: "Narita Brian"
}


let pregunta = prompt("Te gustaria hacerme alguna pregunta? (yes/y)")

if (pregunta == "yes" || pregunta == "y") {

    do {
        let request = prompt("Que te gustaria saber de mi?");

        alert(array2[request]);
        
        pregunta = prompt("Te gustaria hacerme alguna pregunta? (yes/y)")

    } while (pregunta == "yes" || pregunta == "y") 
}


let array = ["Buenos dias", "Mi nombre es Rousselt", "Y soy un guia explorador", "Perteneciente a la division", 24];


plataNeile = prompt("Cuanto dinero tienes, Neile?");
plataNeile = parseFloat (plataNeile);

if (plataNeile >= 0.5 && plataNeile < 1.2) {
    restante = plataNeile - 0.8;
    restante = restante.toFixed(2);
    alert("Con " + plataNeile + "$ puedes comprar un bambino pequeño, y te sobrarian " + restante);
}
    else if (plataNeile >= 1.2 && plataNeile < 1.7) {
        restante = plataNeile - 1.3;
        restante = restante.toFixed(2);
        alert("Con " + plataNeile + "$ puedes comprar un bambino grande, y te sobrarian " + restante);
    }

    else {
        alert("No tenes plata, Neile :(");
    }

    document.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        alert("enter")
    }
});

