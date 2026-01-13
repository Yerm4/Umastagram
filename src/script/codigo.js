const queryMobile = window.matchMedia("(max-width: 600px)").matches;

// Menu contextual personalizado
document.addEventListener("contextmenu", async function(event) {
    return;
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
    
    const opcionSeleccionada = event.target.getAttribute("data-uma");

    if (opcionSeleccionada) {
        buscarUma(opcionSeleccionada);
    }
});

// Cerrar menu contextual
document.addEventListener("click", function(event) {
    const contextMenu = document.getElementById("context-menu");
    
    contextMenu.classList.remove("context-menu-visible")
});

//Buscar Uma
buscarUma("mayano")
async function buscarUma(menu = null) {
    const ruta_img = "src/media/img/";

    let buscador = document.getElementById("nombreUma")
    let nombre = menu ? menu.toLowerCase() : buscador.value.toLowerCase();
    nombre = nombre.trim();

    let dibujar = document.getElementById("dibujar");
    void dibujar.offsetWidth;
    dibujar.style.opacity = "0";
    dibujar.classList.add("animacion-desaparicion")
    await new Promise((resolve) => {
        setTimeout(resolve, 600)
    })
    dibujar.style.background = "var(--fondo)";
    dibujar.innerHTML = ``;
    
    let datos = establo[nombre];

    if (datos) {

        const img = new Image();
        let choosedImage = Math.floor(Math.random() * datos.imagen.length);
        choosedImage = datos.imagen[choosedImage]
        let finalImage = `${ruta_img}${choosedImage}`;
        img.src = `${finalImage}`;
        await new Promise (resolve => img.onload = resolve) 
        
        document.documentElement.style.setProperty(`--uma-color`, datos.color);
        
        
        dibujar.innerHTML = 
        `
            <div class="uma-info" id="uma-info">
                <h2>${datos.nombre}</h2>
                <br>
                <p><strong>Altura:</strong> ${datos.altura.toFixed(2)}</p>
                <p><strong>Cabello:</strong> ${datos.cabello}</p>
                <p><strong>Estilos:</strong> ${datos.estilos}</p>
                <p><strong>Suelo:</strong> ${datos.suelo}</p>
                <p><strong>Distancia:</strong> ${datos.distancia}</p>
                <p><strong>Rival:</strong> ${datos.rival}</p>
                <p><strong>Compañera:</strong> ${datos.compañera}</p>
            </div>
            <div class="container-img-uma">
                <img src="${img.src}" class="img-uma" id="imagen-uma" alt="Imagen de una Uma">
            </div>
        `;

        await new Promise((resolve) => {
            setTimeout(resolve, 400)
        });

        dibujar.style.opacity = "1";
        
        setTimeout( () => {
        let img = document.getElementById("imagen-uma")
        img.classList.add("img-uma-visible");
        }, 100);
        
        buscador.value = "";

        dibujar.classList.remove("animacion-desaparicion")
    } else {
    
        const img = new Image();
        let choosedImage = `${ruta_img}Tazuna_Hayakawa.webp`;
        img.src = `${choosedImage}`;
        await new Promise (resolve => img.onload = resolve) 


        await new Promise((resolve) => {
            setTimeout(resolve, 1000)
        });
        
        dibujar.style.opacity = "1";
        
        dibujar.classList.remove("animacion-desaparicion")
        void dibujar.offsetWidth;

        dibujar.innerHTML = `
            <div class="container-img-uma">
                <h3>No he podido encontrar a <br> esa corredora, entrenador</h3>    
                <div class="tazuna-container"> 
                    <img src="${img.src}" class="img-uma" id="imagen-uma" alt="Imagen de una Uma">
                </div>
            </div>
        `;

        await new Promise((resolve) => {
            setTimeout(resolve, 400)
        });
        
        setTimeout( () => {
        let img = document.getElementById("imagen-uma")
        img.classList.add("img-uma-visible");
        }, 100);
    }
    if (!queryMobile) {
        buscador.focus();
    }
}

//Busqueda "Enter"
function buscarUmaForm(event) {
    event.preventDefault();
    buscarUma();
}

//Modo Oscuro
function modoOscuro() {
    document.body.classList.toggle("modo-oscuro");
}

//Sugerencias de buscador
sugerencias()
function sugerencias() {
    return;
    const lista = document.getElementById("sugerencias-umas");
    const nombres = Object.keys(establo);

    nombres.forEach(nombre => {
        const opcion = document.createElement("option");
        opcion.value = nombre;
        let label = `${establo[nombre].nombre}`
        opcion.textContent = label;
        lista.appendChild(opcion);
    })
}

precargado()
function precargado() {
    let html = document.documentElement;
    
    void html.offsetWidth;
    html.style.opacity = "1";
}



agregarUma();
function agregarUma() {
    
    let nombres = Object.keys(establo);
    
    nombres.sort((a, b) => {
        let nombreA = establo[a].nombre.toLowerCase();
        let nombreB = establo[b].nombre.toLowerCase();
        
        return nombreA.localeCompare(nombreB);
    });

    let umasDisponibles = document.getElementById("umas-disponibles")
        nombres.forEach(llave => {
        let datos = establo[llave];

        let holder = document.createElement("p")
        let nombre = document.createElement("a")
        nombre.setAttribute("href", "#section-1")  
        nombre.setAttribute(`data-uma`, llave);      
        nombre.textContent = `${datos.nombre}`;

        holder.appendChild(nombre)
        umasDisponibles.appendChild(holder)
    });

    umasDisponibles.addEventListener("click", function(event) {
    
        const opcionSeleccionada = event.target.getAttribute("data-uma");
    
        if (opcionSeleccionada) {
            buscarUma(opcionSeleccionada);
        }   
    });
}
