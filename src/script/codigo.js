const queryMobile = window.matchMedia("(max-width: 600px)").matches;

//Buscar Uma

let IRL = false;
let nombreGuardado = "";
buscarUma("mayano")
async function buscarUma(menu = null) {
    const ruta_img = "src/media/img/";
    let IRLButton = document.getElementById("switch-button")
    let caballoSvg = document.getElementById("caballo-svg")
    let umaSvg = document.getElementById("uma-svg")
    let dibujar = document.getElementById("dibujar");
    scrollSection1(event)

    IRLButton.style.opacity = "0"
    IRLButton.classList.add("animacion-desaparicion")
    dibujar.style.opacity = "0";
    dibujar.classList.add("animacion-desaparicion")
    dibujar.classList.add("shake-animacion")
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
        let nombreAproximado = Object.keys(fuente).find(alias => alias.includes(nombre))

        if (nombreAproximado) {
            datos = fuente[nombreAproximado]
        }

        if (!nombreAproximado) {
            
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
            caballoSvg.style.opacity = "1"
            umaSvg.style.opacity = "0"

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
            
            umaSvg.style.opacity = "1"
            caballoSvg.style.opacity = "0"

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

    } 
    
    else {
    
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

 //Cambio de IRL

let switchButton = document.getElementById("switch-button")

switchButton.addEventListener("click", function(event) {
switchButton.style.pointerEvents = "none"
setTimeout(() => {
    switchButton.style.pointerEvents = "auto"
}, 500);
IRL = !IRL
buscarUma(nombreGuardado)
sonido.play()
})

// Mambo 

let sonido = new Audio("src/media/audio/mambo.mp3")
sonido.volume = 0.2

let mambo = document.querySelectorAll(".mambo-spinning")

mambo.forEach(mambo => {
    mambo.addEventListener("click", function(event) {
        buscarUma("mambo")
        sonido.currentTime = 0
        sonido.play()
    })    
});



//Busqueda "Enter"

function buscarUmaForm(event) {
    event.preventDefault();
    buscarUma();
}

//Modo Oscuro

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

//Sugerencias de buscador

precargado()
function precargado() {
    let html = document.documentElement;
    
    void html.offsetWidth;
    html.style.opacity = "1";
}

//Agregar umas a lista de disponibles

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
    window.scrollTo({
        top: 0
    })
}