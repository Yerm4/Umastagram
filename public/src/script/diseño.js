document.addEventListener("DOMContentLoaded", (e) => {
    let body = document.body;

    void body.offsetWidth;
    body.style.opacity = "1";
})

const preferredThemeSaved = localStorage.getItem("theme");
const preferredTheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
const themeToggle = document.getElementById("theme-toggle") 
const botonOscuro = document.getElementById("modo-oscuro")
const botonClaro = document.getElementById("modo-claro")

if (preferredThemeSaved === "dark" || (!preferredThemeSaved && preferredTheme)) {
    document.body.classList.add("modo-oscuro")
    themeToggle.dataset.theme = "toLight"
    botonOscuro.style.visibility = "hidden" 
    botonClaro.style.visibility = "visible" 

    localStorage.setItem("theme", "dark");
} else {
    document.body.classList.remove("modo-oscuro")
    themeToggle.dataset.theme = "toDark"
    botonClaro.style.visibility = "hidden"
    botonOscuro.style.visibility = "visible"  

    localStorage.setItem("theme", "light");
}

themeToggle.addEventListener("click", (e) => {
    e.preventDefault()
    let theme = themeToggle.dataset.theme

    if (theme === "toLight") {
        document.body.classList.remove("modo-oscuro")
        themeToggle.dataset.theme = "toDark"
        botonClaro.style.visibility = "hidden"
        botonOscuro.style.visibility = "visible" 
        
        localStorage.setItem("theme", "light");
    }

    if (theme === "toDark") {
        document.body.classList.add("modo-oscuro")
        themeToggle.dataset.theme = "toLight"
        botonOscuro.style.visibility = "hidden" 
        botonClaro.style.visibility = "visible" 
        
        localStorage.setItem("theme", "dark");
    }
})
