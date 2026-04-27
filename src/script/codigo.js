const queryMobile = window.matchMedia("(max-width: 600px)").matches;

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

let IRL = false;
let nombreGuardado;
//Buscar Uma
buscarUma("mayano")
async function buscarUma(menu = null) {
    const ruta_img = "src/media/img/";
    let IRLButton = document.getElementById("switch-button")

    let dibujar = document.getElementById("dibujar");
    void dibujar.offsetWidth;
    void IRLButton.offsetWidth;
    IRLButton.style.opacity = "0"
    IRLButton.classList.add("animacion-desaparicion")
    dibujar.style.opacity = "0";
    dibujar.classList.add("animacion-desaparicion")
    await new Promise((resolve) => {
        setTimeout(resolve, 600)
    })

    if (!IRL) {
        fuente = establo
    }

    if (IRL) {
        fuente = establoReal
    }

    let buscador = document.getElementById("nombreUma")
    let nombre = menu ? menu.toLowerCase() : buscador.value.toLowerCase();
    nombre = nombre.trim();

    nombreGuardado = nombre;
    
    let datos = fuente[nombre];

    if (!datos && nombre.length > 0) {
        let nombreAproximado = Object.keys(establo).find(alias => alias.includes(nombre))

        if (nombreAproximado) {
            datos = establo[nombreAproximado]
        }
    }

    if (datos) {
        
        const img = new Image();
        let choosedImage = Math.floor(Math.random() * datos.imagen.length);
        choosedImage = datos.imagen[choosedImage]
        let finalImage = `${ruta_img}${choosedImage}`;
        img.src = `${finalImage}`;
        await new Promise (resolve => img.onload = resolve) 
        
        document.documentElement.style.setProperty(`--uma-color`, datos.color);
        
        function crearDato(texto, valor) {
            let p = document.createElement("p")
            let s = document.createElement("strong")

            s.textContent = texto + ": "
            p.append(s, valor)
            return p;
        }

        // Dibujar Uma
        if (!IRL) {
            dibujar.classList.remove("dibujar-column")
            IRLButton.textContent = "Caballo - IRL"

            dibujar.textContent = ""
            
            let infoContainer = document.createElement("div")
            infoContainer.classList.add("uma-info")
            infoContainer.id = "uma-info"

            let imgContainer = document.createElement("div")
            imgContainer.classList.add("container-img-uma")
            
            let h2 = document.createElement("h2")
            h2.textContent = datos.nombre

            let imagen = document.createElement("img")
            imagen.src = img.src
            imagen.classList.add("img-uma")
            imagen.id = "img-uma"
            imagen.alt = "Imagen de un caballo"

            infoContainer.append(
                h2,
                document.createElement("br"),
                crearDato("Altura", datos.altura),
                crearDato("Cabello", datos.cabello),
                crearDato("Estilos", datos.estilos),
                crearDato("Suelo", datos.suelo),
                crearDato("Distancia", datos.distancia),
                crearDato("Rival", datos.rival),
                crearDato("Compañera", datos.compañera)
            )

            imgContainer.append(
                imagen
            )
            
            dibujar.append(infoContainer, imgContainer)
        }

        // Dibujar caballo
        if (IRL) {
            dibujar.classList.add("dibujar-column")
            IRLButton.textContent = "Uma Musume"
            dibujar.textContent = ""
            
            let infoContainer = document.createElement("div")
            infoContainer.classList.add("uma-info")
            infoContainer.id = "uma-info"

            let imgContainer = document.createElement("div")
            imgContainer.classList.add("container-img-uma")
            
            let h2 = document.createElement("h2")
            h2.textContent = datos.nombre

            let imagen = document.createElement("img")
            imagen.src = img.src
            imagen.classList.add("img-uma")
            imagen.classList.add("img-caballo")
            imagen.id = "img-uma"
            imagen.alt = "Imagen de un caballo"

            infoContainer.append(
                h2,
                document.createElement("br"),
                crearDato("Nacimiento", datos.nacimiento),
                crearDato("Sexo", datos.sexo),
                crearDato("Fallecimiento", datos.fallecimiento),
                crearDato("Cabello", datos.cabello),
                crearDato("Carreras", datos.carreras),
                crearDato("Victorias", datos.victorias),
                crearDato("Padre", datos.padre),
                crearDato("Madre", datos.madre)
            )
            imgContainer.append(
                imagen
            )
            
            dibujar.append(infoContainer, imgContainer)
        }

        await new Promise((resolve) => {
            setTimeout(resolve, 400)
        });

        dibujar.style.opacity = "1";
        IRLButton.style.opacity = "1"
        
        setTimeout( () => {
        let img = document.getElementById("img-uma")
        img.classList.add("img-uma-visible");
        }, 100);
        
        buscador.value = "";

        dibujar.classList.remove("animacion-desaparicion")
        IRLButton.classList.remove("animacion-desaparicion")

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

let sonido = new Audio("src/media/audio/mambo.mp3")
sonido.volume = 0.2
 //Cambio de contenido 
let switchButton = document.getElementById("switch-button")

switchButton.addEventListener("click", function(event) {
IRL = !IRL
buscarUma(nombreGuardado)
sonido.play()
})

// Mambo 
let mambo = document.querySelectorAll(".mambo-spinning")

mambo.forEach(mambo => {
    mambo.addEventListener("click", function(event) {
        buscarUma("mambo")
        sonido.play()
    })    
});



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

        let container = document.createElement("div")
        let nombre = document.createElement("a")
       // let imagen = document.createElement("img")

        container.setAttribute("class", "umas-disponibles-container")
        nombre.setAttribute("href", "#")
        nombre.setAttribute("onclick", "scrollSection1(event)")  
        nombre.setAttribute(`data-uma`, llave);      
        nombre.textContent = `${datos.nombre}`;
        //imagen.setAttribute("src", `src/media/img/${datos.imagen[0]}`)

        container.appendChild(nombre)
        //container.appendChild(imagen)
        umasDisponibles.appendChild(container)
    });

    umasDisponibles.addEventListener("click", function(event) {
    
        const opcionSeleccionada = event.target.getAttribute("data-uma");
    
        if (opcionSeleccionada) {
            buscarUma(opcionSeleccionada);
        }   
    });
}

function scrollSection1 (event) {
    event.preventDefault()
    let seccion1 = document.getElementById("section-1")
    seccion1.scrollIntoView()
}