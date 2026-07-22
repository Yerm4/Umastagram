const queryMobile = window.matchMedia("(pointer: fine)").matches;

// Buscar Uma
let IRL = false;
let nombreGuardado = "";

buscarUma("mayano");

async function buscarUma(menu = null) {
    const ruta_img = "src/media/img/";
    const IRLButton = document.getElementById("switch-button");
    const caballoSvg = document.getElementById("caballo-svg");
    const umaSvg = document.getElementById("uma-svg");
    const dibujar = document.getElementById("dibujar");
    
    scrollSection1(event);

    IRLButton.style.opacity = "0";
    IRLButton.classList.add("animacion-desaparicion");
    dibujar.style.opacity = "0";
    dibujar.classList.add("animacion-desaparicion");
    dibujar.classList.add("shake-animacion");

    await new Promise((resolve) => {
        setTimeout(resolve, 600);
    });

    let fuente = establo;
    if (IRL) {
        fuente = establoReal;
    }

    const buscador = document.getElementById("nombreUma");
    let nombre = menu ? menu.toLowerCase() : buscador.value.toLowerCase();
    nombre = nombre.trim();
    
    if (queryMobile) {
        buscador.focus();
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

        // Dibujar Uma
        if (!IRL) {
            dibujar.classList.remove("dibujar-column");
            caballoSvg.style.opacity = "1";
            umaSvg.style.opacity = "0";

            dibujar.textContent = "";
            
            const infoContainer = document.createElement("div");
            infoContainer.classList.add("uma-info");
            infoContainer.id = "uma-info";

            const imgContainer = document.createElement("div");
            imgContainer.classList.add("container-img-uma");
            
            const h2 = document.createElement("h2");
            h2.textContent = datos.nombre;

            const imagen = document.createElement("img");
            imagen.src = img.src;
            imagen.classList.add("img-uma");
            imagen.id = "img-uma";
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
            dibujar.append(infoContainer, imgContainer);
        }

        // Dibujar caballo
        if (IRL) {
            dibujar.classList.add("dibujar-column");
            
            umaSvg.style.opacity = "1";
            caballoSvg.style.opacity = "0";

            dibujar.textContent = "";
            
            const infoContainer = document.createElement("div");
            infoContainer.classList.add("uma-info");
            infoContainer.id = "uma-info";

            const imgContainer = document.createElement("div");
            imgContainer.classList.add("container-img-uma");
            
            const h2 = document.createElement("h2");
            h2.textContent = datos.nombre;

            const imagen = document.createElement("img");
            imagen.src = img.src;
            imagen.classList.add("img-uma");
            imagen.classList.add("img-caballo");
            imagen.id = "img-uma";
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
            dibujar.append(infoContainer, imgContainer);
        }

        await new Promise((resolve) => {
            setTimeout(resolve, 400);
        });

        dibujar.style.opacity = "1";
        IRLButton.style.opacity = "1";
        
        setTimeout(() => {
            const imgUma = document.getElementById("img-uma");
            if (imgUma) imgUma.classList.add("img-uma-visible");
        }, 100);
        
        buscador.value = "";

        dibujar.classList.remove("animacion-desaparicion");
        IRLButton.classList.remove("animacion-desaparicion");

    } else {
        const img = new Image();
        const choosedImage = `${ruta_img}Tazuna_Hayakawa.webp`;
        img.src = `${choosedImage}`;
        await new Promise(resolve => img.onload = resolve);

        await new Promise((resolve) => {
            setTimeout(resolve, 1000);
        });
        
        dibujar.style.opacity = "1";
        dibujar.classList.remove("animacion-desaparicion");
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
            setTimeout(resolve, 400);
        });
        
        setTimeout(() => {
            const imgUma = document.getElementById("imagen-uma");
            if (imgUma) imgUma.classList.add("img-uma-visible");
        }, 100);
    }
}

// Cambio de IRL
const switchButton = document.getElementById("switch-button");

switchButton.addEventListener("click", (e) => {
    switchButton.style.pointerEvents = "none";
    setTimeout(() => {
        switchButton.style.pointerEvents = "auto";
    }, 500);
    IRL = !IRL;
    buscarUma(nombreGuardado);
    sonido.play();
});

// Audio
const sonido = new Audio("src/media/audio/mambo.mp3");
sonido.volume = 0.2;

const mambo = document.querySelectorAll(".mambo-spinning");

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

    const umasDisponibles = document.getElementById("umas-disponibles");
    
    nombres.forEach(llave => {
        const datos = establo[llave];
        const container = document.createElement("div");
        const nombre = document.createElement("a");

        container.setAttribute("class", "umas-disponibles-container");
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

// Login
const rawLogin = document.getElementById("main").dataset.login;
const isLogin = rawLogin === "true" ? true : false;
const modales = document.querySelectorAll("dialog[name=modal]")
const modalesButton = document.querySelectorAll("[name=buttonModal]")
if (!isLogin) {
    console.log("no logueado");
    
    modales.forEach(modal => {
        modal.addEventListener("click", (event) => {
            if (event.clientX === 0 && event.clientY === 0) {
                return; 
            }
            const modalPosicion = modal.getBoundingClientRect()
            const clickAfuera = (
                event.clientX < modalPosicion.left ||
                event.clientX > modalPosicion.right ||
                event.clientY < modalPosicion.top ||
                event.clientY > modalPosicion.bottom 
            )
            if (clickAfuera) {
                modal.style.opacity = 0
                setTimeout(() => {
                modal.close()
                }, 150);
            }
        })
    })

    modalesButton.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault()
            const buttonId = button.dataset.modal
            const modal = document.getElementById(buttonId)
            modal.showModal()
        })
    })

    const loginModal = document.getElementById("loginModal");
    const registroModal = document.getElementById("registroModal");

    const modalButtonClose = document.querySelectorAll(".svg-dialog-close")
    modalButtonClose.forEach(button => {
        button.addEventListener("click", (e) => {
            const buttonId = button.dataset.modal
            const modal = document.getElementById(buttonId)
            modal.close()
        })
    })

    const switchToRegistro = document.getElementById("switchToRegistro");
    switchToRegistro.addEventListener("click", function(event) {
        event.preventDefault();
        loginModal.classList.add("modal-fade");
        setTimeout(() => {
            loginModal.classList.remove("modal-fade");
            loginModal.close();
            registroModal.showModal();
        }, 1500);
    });

    const switchToLogin = document.getElementById("switchToLogin");
    switchToLogin.addEventListener("click", function(event) {
        event.preventDefault();
        registroModal.classList.add("modal-fade");
        setTimeout(() => {
            registroModal.classList.remove("modal-fade");
            registroModal.close();
            loginModal.showModal();
        }, 1500);
    });
} else {
    console.log("logueado");
}

const inputNombre = document.querySelectorAll("[name=nombre]") 
inputNombre.forEach(input => {
    input.addEventListener("input", (e) => {
        const target = e.target;
        target.value = target.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]/g, '');
        
        if (target.value.length > 20) {
            target.value = target.value.slice(0, 20);
        }        
    })
})