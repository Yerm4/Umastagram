document.addEventListener("DOMContentLoaded", (e) => {
    let body = document.body;

    void body.offsetWidth;
    body.style.opacity = "1";
})

const themeToggle = document.getElementById("theme-toggle") 
const botonOscuro = document.getElementById("modo-oscuro")
const botonClaro = document.getElementById("modo-claro")

if (preferredThemeSaved === "dark" || (!preferredThemeSaved && preferredTheme)) {
    document.documentElement.classList.add("modo-oscuro")
    themeToggle.dataset.theme = "toLight"
    botonOscuro.style.visibility = "hidden" 
    botonClaro.style.visibility = "visible" 

    localStorage.setItem("theme", "dark");
} else {
    document.documentElement.classList.remove("modo-oscuro")
    themeToggle.dataset.theme = "toDark"
    botonClaro.style.visibility = "hidden"
    botonOscuro.style.visibility = "visible"  

    localStorage.setItem("theme", "light");
}

themeToggle.addEventListener("click", (e) => {
    e.preventDefault()
    let theme = themeToggle.dataset.theme

    if (theme === "toLight") {
        document.documentElement.classList.remove("modo-oscuro")
        themeToggle.dataset.theme = "toDark"
        botonClaro.style.visibility = "hidden"
        botonOscuro.style.visibility = "visible" 
        
        localStorage.setItem("theme", "light");
    }

    if (theme === "toDark") {
        document.documentElement.classList.add("modo-oscuro")
        themeToggle.dataset.theme = "toLight"
        botonOscuro.style.visibility = "hidden" 
        botonClaro.style.visibility = "visible" 
        
        localStorage.setItem("theme", "dark");
    }
})