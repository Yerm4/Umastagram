precargado()
function precargado() {
    let body = document.body;
    
    void body.offsetWidth;
    body.style.opacity = "1";
}

const botonOscuro = document.getElementById("modo-oscuro")
    if (botonOscuro) {
        botonOscuro.addEventListener("click", () => {
        document.body.classList.add("modo-oscuro")
        botonOscuro.style.visibility = "hidden" 
    
        botonClaro.style.visibility = "visible"    
    })
}

const botonClaro = document.getElementById("modo-claro")
    if (botonClaro) {
        botonClaro.addEventListener("click", () => {
            document.body.classList.remove("modo-oscuro")
            botonClaro.style.visibility = "hidden"
        
            botonOscuro.style.visibility = "visible"
    })
}
