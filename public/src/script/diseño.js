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