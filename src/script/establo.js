// Buscar Uma
let IRL = false;
let nombreGuardado = "";

buscarUma("mayano");

async function buscarUma(menu = null) {
    const ruta_img = "src/media/img/";
    const IRLButton = document.getElementById("switch-button");
    if (!IRLButton) {
        return
    }
    const caballoSvg = document.getElementById("irl-button__horse-icon");
    const umaSvg = document.getElementById("irl-button__uma-icon");
    const drawCard = document.getElementById("draw-card");
    
    scrollSection1(event);

    IRLButton.style.opacity = "0";
    IRLButton.classList.add("anim-disappear");
    drawCard.style.opacity = "0";
    drawCard.classList.add("anim-disappear");

    await new Promise((resolve) => {
        setTimeout(resolve, 600);
    });

    let fuente = establo;
    if (IRL) {
        fuente = establoReal;
    }

    const searchBoxInput = document.getElementById("nombreUma");
    let nombre = menu ? menu.toLowerCase() : searchBoxInput.value.toLowerCase();
    nombre = nombre.trim();
    
    if (queryMobile) {
        searchBoxInput.focus();
    }
    nombreGuardado = nombre;
    
    let datos = fuente[nombre];

    if (!datos && nombre.length > 0) {
        const nombreAproximado = Object.keys(fuente).find(alias => alias.includes(nombre));

        if (nombreAproximado) {
            datos = fuente[nombreAproximado];
        }
    }

    if (!datos && nombre.length === 0) {
        datos = fuente["oguri"];
    }

    if (datos) {
        const img = new Image();
        const choosedIndex = Math.floor(Math.random() * datos.imagen.length);
        const choosedImage = datos.imagen[choosedIndex];
        const finalImage = `${ruta_img}${choosedImage}`;
        
        img.src = `${finalImage}`;
        await new Promise(resolve => img.onload = resolve);
        
        document.documentElement.style.setProperty(`--uma-color`, datos.color);
        
        function crearDato(texto, valor) {
            const p = document.createElement("p");
            const s = document.createElement("strong");

            s.textContent = texto + ": ";
            p.append(s, valor);
            return p;
        }

        // drawCard Uma

        if (!IRL) {
            drawCard.classList.remove("draw-card--column");
            caballoSvg.style.opacity = "1";
            umaSvg.style.opacity = "0";

            drawCard.textContent = "";
            
            const infoContainer = document.createElement("div");
            infoContainer.classList.add("uma-info");
            infoContainer.id = "uma-info";

            const imgContainer = document.createElement("div");
            imgContainer.classList.add("draw-card__img-container");
            
            const h2 = document.createElement("h2");
            h2.textContent = datos.nombre;

            const imagen = document.createElement("img");
            imagen.src = img.src;
            imagen.classList.add("draw-card__uma-img");
            imagen.id = "draw-card__uma-img";
            imagen.alt = "Imagen de un caballo";

            infoContainer.append(
                h2,
                document.createElement("br"),
                crearDato("Altura", datos.altura.toFixed(2)),
                crearDato("Cabello", datos.cabello),
                crearDato("Estilos", datos.estilos),
                crearDato("Suelo", datos.suelo),
                crearDato("Distancia", datos.distancia),
                crearDato("Rival", datos.rival),
                crearDato("Compañera", datos.compañera)
            );

            imgContainer.append(imagen);
            drawCard.append(infoContainer, imgContainer);
        }

        // drawCard caballo
        if (IRL) {
            drawCard.classList.add("draw-card--column");
            
            umaSvg.style.opacity = "1";
            caballoSvg.style.opacity = "0";

            drawCard.textContent = "";
            
            const infoContainer = document.createElement("div");
            infoContainer.classList.add("uma-info");
            infoContainer.id = "uma-info";

            const imgContainer = document.createElement("div");
            imgContainer.classList.add("draw-card__hose-img-container");
            
            const h2 = document.createElement("h2");
            h2.textContent = datos.nombre;

            const imagen = document.createElement("img");
            imagen.src = img.src;
            imagen.classList.add("draw-card__uma-img");
            imagen.classList.add("draw-card__horse-img");
            imagen.id = "draw-card__uma-img";
            imagen.alt = "Imagen de un caballo";

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
            );

            imgContainer.append(imagen);
            drawCard.append(infoContainer, imgContainer);
        }

        await new Promise((resolve) => {
            setTimeout(resolve, 400);
        });

        drawCard.style.opacity = "1";
        IRLButton.style.opacity = "1";
        
        setTimeout(() => {
            const imgUma = document.getElementById("draw-card__uma-img");
            if (imgUma) imgUma.classList.add("draw-card__uma-img--visible");
        }, 100);
        
        searchBoxInput.value = "";

        drawCard.classList.remove("anim-disappear");
        IRLButton.classList.remove("anim-disappear");

    } else {
        const img = new Image();
        const choosedImage = `${ruta_img}Tazuna_Hayakawa.webp`;
        img.src = `${choosedImage}`;
        await new Promise(resolve => img.onload = resolve);

        await new Promise((resolve) => {
            setTimeout(resolve, 1000);
        });
        
        drawCard.style.opacity = "1";
        drawCard.classList.remove("anim-disappear");
        void drawCard.offsetWidth;

        drawCard.innerHTML = `
            <div class="draw-card__uma-img">
                <h3>No he podido encontrar a <br> esa corredora, entrenador</h3>    
                <div class="draw-card__tazuna-container"> 
                    <img src="${img.src}" class="draw-card__uma-img" id="imagen-uma" alt="Imagen de una Uma">
                </div>
            </div>
        `;

        await new Promise((resolve) => {
            setTimeout(resolve, 400);
        });
        
        setTimeout(() => {
            const imgUma = document.getElementById("imagen-uma");
            if (imgUma) imgUma.classList.add("draw-card__uma-img--visible");
        }, 100);
    }
}

// Cambio de IRL
const switchButton = document.getElementById("switch-button");

if (switchButton) {
    switchButton.addEventListener("click", (e) => {
        switchButton.style.pointerEvents = "none";
        setTimeout(() => {
            switchButton.style.pointerEvents = "auto";
        }, 500);
        IRL = !IRL;
        buscarUma(nombreGuardado);
        sonido.play();
    });
}

// Audio
const sonido = new Audio("src/media/audio/mambo.mp3");
sonido.volume = 0.2;

const mambo = document.querySelectorAll(".mambo-wrapper__video");

mambo.forEach(elementoMambo => {
    elementoMambo.addEventListener("click", function(event) {
        buscarUma("mambo");
        sonido.currentTime = 0;
        sonido.play();
    });    
});

// Búsqueda "Enter"
function buscarUmaForm(event) {
    event.preventDefault();
    buscarUma();
}

agregarUma();

function agregarUma() { // Agregar umas a lista de umas disponibles
    
    const nombres = Object.keys(establo);
    
    nombres.sort((a, b) => {
        const nombreA = establo[a].nombre.toLowerCase();
        const nombreB = establo[b].nombre.toLowerCase();
        return nombreA.localeCompare(nombreB);
    });

    const umasDisponibles = document.getElementById("available-section__grid");
    
    nombres.forEach(llave => {
        const datos = establo[llave];
        const container = document.createElement("div");
        const nombre = document.createElement("a");

        container.setAttribute("class", "available-section__grid-container");
        nombre.setAttribute("href", "#");
        nombre.setAttribute("onclick", "scrollSection1(event)");  
        nombre.setAttribute("data-uma", llave);      
        nombre.textContent = `${datos.nombre}`;

        container.appendChild(nombre);
        umasDisponibles.appendChild(container);
    });

    umasDisponibles.addEventListener("click", function(event) {
        const opcionSeleccionada = event.target.getAttribute("data-uma");
        if (opcionSeleccionada) {
            buscarUma(opcionSeleccionada);
        }   
    });
}

function scrollSection1(event) {
    window.scrollTo({
        top: 0
    });
}