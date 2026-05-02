// Menu contextual personalizado
document.addEventListener("contextmenu", async function(event) {
    return

    const contextMenu = document.getElementById("context-menu");
    event.preventDefault();

    contextMenu.classList.remove("context-menu-visible");
    contextMenu.classList.remove("context-menu-animacion")

    let menuAncho = contextMenu.offsetWidth;
    let menuAlto = contextMenu.offsetHeight;

    let y = event.clientY;
    let x = event.clientX;

    if (x + menuAncho > window.innerWidth) {
        x = x - menuAncho;
    }

    if (y + menuAlto > window.innerHeight) {
        y = y - menuAlto;
    }

    contextMenu.style.top = y + "px";
    contextMenu.style.left = x + "px";
    
    void contextMenu.offsetWidth;
    contextMenu.classList.add("context-menu-animacion");
    contextMenu.classList.add("context-menu-visible");
});

//Añadir opciones a menu contextual
agregarOpciones();
function agregarOpciones() {

    return

    let menuContextual = document.getElementById("context-menu");
    menuContextual.innerHTML = ` `;
    let nombres = Object.keys(establo);

    nombres.forEach(llave => {
        let datos = establo[llave];

        let opcion = document.createElement("p")
        let nombre = document.createElement("span")
        opcion.classList.add("p-container")
        nombre.setAttribute(`data-uma`, llave);
        nombre.textContent = `${datos.nombre}`;
        nombre.classList.add("opcion");
        nombre.style.borderRight = `4px solid ${datos.color}`
        
        let imagen = document.createElement("img")
        imagen.src = `src/media/img/mini/${datos.imagen[0]}`
        imagen.classList.add("mini-imagen");

        opcion.appendChild(nombre);
        opcion.appendChild(imagen);

        menuContextual.appendChild(opcion)
    });
}

//Elegir opcion del menu contextual
document.getElementById("context-menu").addEventListener("click", function(event) {
    
    return

    const opcionSeleccionada = event.target.getAttribute("data-uma");

    if (opcionSeleccionada) {
        buscarUma(opcionSeleccionada);
    }
});

// Cerrar menu contextual
document.addEventListener("click", function(event) {
    return

    const contextMenu = document.getElementById("context-menu");
    
    contextMenu.classList.remove("context-menu-visible")
});

sugerencias()
function sugerencias() {
    
    const lista = document.getElementById("sugerencias-umas");
    const nombres = Object.keys(establo);

    nombres.sort(() => Math.random() - 0.5)
    nombres.slice(0, 8).forEach(nombre => {
        const opcion = document.createElement("option");
        opcion.value = nombre;
        let label = `${establo[nombre].nombre}`
        opcion.textContent = label;
        opcion.classList = "opcion"
        lista.appendChild(opcion);
    })
}