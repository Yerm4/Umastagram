const buttonLike = document.querySelectorAll("[name=button-like]")

if (buttonLike) {
    buttonLike.forEach(button => {
        button.addEventListener("click", (e) => {
            const postId = button.dataset.postId
            fetch('index.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({
                    form: 'actualizar_likes',
                    data: postId
                })
            })
            .then(response => response.json())
            .then(data => {
                
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
        })
    });
}

const loginForm = document.getElementById("loginForm") 
const loginError = document.getElementById("loginError")
if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault()
        const formData = new FormData (loginForm)
        const datos = Object.fromEntries(formData.entries())
    
        fetch("index.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en el servidor")
            }
            return response.json()
        })
        .then(data => {
            if (data.status === "ok") {
                window.location.href = data.redirect;
            } else {
                loginError.innerHTML = data.message
            }
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        })
    })
}

const signUpForm = document.getElementById("signUpForm") 
const signUpError = document.getElementById("signUpError")

if (signUpForm) {
    signUpForm.addEventListener("submit", (e) => {
        e.preventDefault()

        const formData = new FormData(signUpForm)
        const datos = Object.fromEntries(formData.entries())

        fetch("index.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en el servidor")
            }
            return response.json()
        })
        .then(data => {
            if (data.status === "ok") {
                window.location.href = data.redirect;
            } else {
                signUpError.innerHTML = data.message
            }
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        })
    })
}