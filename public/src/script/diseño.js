const queryMobile = window.matchMedia("(pointer: fine)").matches

document.addEventListener("DOMContentLoaded", () => {
    const body = document.body

    if (body) {
        void body.offsetWidth
        body.style.opacity = "1"
    }

    const themeToggle = document.getElementById("theme-toggle")
    const botonOscuro = document.getElementById("modo-oscuro")
    const botonClaro = document.getElementById("modo-claro")

    if (themeToggle && botonOscuro && botonClaro) {
        const preferredThemeSaved = localStorage.getItem("theme")
        const preferredTheme = window.matchMedia("(prefers-color-scheme: dark)").matches
        const isDark = preferredThemeSaved === "dark" || (!preferredThemeSaved && preferredTheme)

        if (isDark) {
            themeToggle.dataset.theme = "toLight"
            botonOscuro.style.visibility = "hidden"
            botonClaro.style.visibility = "visible"
        } else {
            themeToggle.dataset.theme = "toDark"
            botonClaro.style.visibility = "hidden"
            botonOscuro.style.visibility = "visible"
        }

        themeToggle.addEventListener("click", (e) => {
            e.preventDefault()
            const isToLight = themeToggle.dataset.theme === "toLight"

            document.documentElement.classList.toggle("modo-oscuro", !isToLight)
            themeToggle.dataset.theme = isToLight ? "toDark" : "toLight"
            botonOscuro.style.visibility = isToLight ? "visible" : "hidden"
            botonClaro.style.visibility = isToLight ? "hidden" : "visible"
            localStorage.setItem("theme", isToLight ? "light" : "dark")
        })
    }
})

const mambos = document.querySelectorAll(".mambo-wrapper__video")

mambos.forEach(mambo => {
    mambo.playbackRate = 3
    mambo.addEventListener("click", (e) => {
        let p = mambo.playbackRate
        if(p < 16) mambo.playbackRate = p+1
    })    
})

const phrases = [
    {
    id: "input-titulo",
    textos: ["Escribe un título...", "Tus besos frios como la lluvia", "Mayano mi mujer", "Titulo alfa buena maravilla onda dinamita escuadrón lobo"]
    },
    {
    id: "input-contenido",
    textos: ["Escribe el contenido...", "Había una vez...", "Soy lesbiana", "Lorem ipsum dolor..."]
    }
]

function writeMachine(id, arrayPhrases) {
    const input = document.getElementById(id)

    if (!input) return;
    let currentPhrase = 0
    let currentChar = 0
    let isErasing = false

    function type() {
    const phrase = arrayPhrases[currentPhrase]
    
    if (isErasing) {
        input.placeholder = phrase.substring(0, currentChar - 1)
        currentChar--
    } else {
        input.placeholder = phrase.substring(0, currentChar + 1)
        currentChar++
    }

    let typingSpeed = isErasing ? 10 : 50

    if (!isErasing && currentChar === phrase.length) {
        typingSpeed = 3000
        isErasing = true
    } 
    else if (isErasing && currentChar === 0) {
        isErasing = false
        currentPhrase = (currentPhrase + 1) % arrayPhrases.length
        typingSpeed = 2000
    }

    setTimeout(type, typingSpeed)
    }

    type()
}

window.addEventListener("DOMContentLoaded", () => {
    phrases.forEach(p => {
    writeMachine(p.id, p.textos)
    })
})

const establoo = {
    "Agnes Tachyon": {
        imagen: ["Agnes_Tachyon.webp", "Agnes_Tachyon_Alt(1).webp", "Agnes_Tachyon_Alt(2).webp"]
    },
    "Almond Eye": {
        imagen: ["Almond_Eye.webp", "Almond_Eye_Alt(1).webp", "Almond_Eye_Alt(2).webp"]
    },
    "Daiwa Scarlet": {
        imagen: ["Daiwa_Scarlet.webp", "Daiwa_Scarlet_Alt(1).webp", "Daiwa_Scarlet_Alt(2).webp"]
    },
    "El Condor Pasa": {
        imagen: ["El_Condor_Pasa.webp", "El_Condor_Pasa_Alt(1).webp", "El_Condor_Pasa_Alt(2).webp", "El_Condor_Pasa_Alt(3).webp"]
    },
    "Gold Ship": {
        imagen: ["Gold_Ship.webp", "Gold_Ship_Alt(1).webp", "Gold_Ship_Alt(2).webp"]
    },
    "Haru Urara": {
        imagen: ["Haru_Urara.webp", "Haru_Urara_Alt(1).webp", "Haru_Urara_Alt(2).webp"]
    },
    "Kitasan Black": {
        imagen: ["Kitasan_Black.webp", "Kitasan_Black_Alt(1).webp", "Kitasan_Black_Alt(2).webp"]
    },
    "Manhattan Cafe": {
        imagen: ["Manhattan_Cafe.webp", "Manhattan_Cafe_Alt(1).webp", "Manhattan_Cafe_Alt(2).webp"]
    },
    "Maruzensky": {
        imagen: ["Maruzensky.webp", "Maruzensky_Alt(1).webp", "Maruzensky_Alt(2).webp"]
    },
    "Matikanetannhauser": {
        imagen: ["Matikanetannhauser.webp", "Matikanetannhauser.webp"]
    },
    "Mayano Top Gun": {
        imagen: ["Mayano_Top_Gun.webp", "Mayano_Top_Gun_Alt(1).webp", "Mayano_Top_Gun_Alt(2).webp", "Mayano_Top_Gun_Alt(3).webp"]
    },
    "Narita Brian": {
        imagen: ["Narita_Brian.webp", "Narita_Brian_Alt(1).webp", "Narita_Brian_Alt(2).webp"]
    },
    "Oguri Cap": {
        imagen: ["Oguri_Cap.webp", "Oguri_Cap_Alt(1).webp", "Oguri_Cap_Alt(2).webp"]
    },
    "Rice Shower": {
        imagen: ["Rice_Shower.webp", "Rice_Shower_Alt(1).webp", "Rice_Shower_Alt(2).webp"]
    },
    "Satono Diamond": {
        imagen: ["Satono_Diamond.webp", "Satono_Diamond_Alt(1).webp", "Satono_Diamond_Alt(2).webp"]
    },
    "Silence Suzuka": {
        imagen: ["Silence_Suzuka.webp", "Silence_Suzuka_Alt(1).webp"]
    },
    "Special Week": {
        imagen: ["Special_Week.webp", "Special_Week_Alt(1).webp", "Special_Week_Alt(2).webp", "Special_Week_Alt(3).webp", "Special_Week_Alt(4).webp"]
    },
    "Stay Gold": {
        imagen: ["Stay_Gold.webp", "Stay_Gold_Alt(1).webp"]
    },
    "Symboli Rudolf": {
        imagen: ["Symboli_Rudolf.webp", "Symboli_Rudolf_Alt(1).webp", "Symboli_Rudolf_Alt(2).webp"]
    },
    "Taiki Shuttle": {
        imagen: ["Taiki_Shuttle.webp", "Taiki_Shuttle_Alt(1).webp", "Taiki_Shuttle_Alt(2).webp"]
    },
    "Tamamo Cross": {
        imagen: ["Tamamo_Cross.webp", "Tamamo_Cross_Alt(1).webp", "Tamamo_Cross_Alt(2).webp"]
    },
    "Tokai Teio": {
        imagen: ["Tokai_Teio.webp", "Tokai_Teio_Alt(1).webp", "Tokai_Teio_Alt(2).webp"]
    },
    "Vodka": {
        imagen: ["Vodka.webp", "Vodka_Alt(1).webp", "Vodka_Alt(2).webp"]
    }
};