precargado()
function precargado() {
    let body = document.body;
    
    void body.offsetWidth;
    body.style.opacity = "1";
}

let botonOscuro = document.getElementById("modo-oscuro")

botonOscuro.addEventListener("click", () => {
    document.body.classList.add("modo-oscuro")
    botonOscuro.style.visibility = "hidden" 

    botonClaro.style.visibility = "visible"
})

let botonClaro = document.getElementById("modo-claro")

botonClaro.addEventListener("click", () => {
    document.body.classList.remove("modo-oscuro")
    botonClaro.style.visibility = "hidden"

    botonOscuro.style.visibility = "visible"
})
