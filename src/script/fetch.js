const buttonLike = document.querySelectorAll("[name=button-like]")

if (buttonLike) {
    buttonLike.forEach(button => {
        button.addEventListener("click", (e) => {
            const postId = button.dataset.postId
            const like = document.querySelector(`[name="likes"][data-post-id="${postId}"]`)
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
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error en el servidor")
                }
                return response.json()
            })
            
            .then(data => {
                if (data.status === "ok") {
                    console.log("like dado, esta publicacion tiene: "+data.data+" Likes")
                    like.innerHTML = data.data
                } else {
                    console.log("like no dado")
                }
            
            })
            .catch(error => console.error('Error:', error));
        })
    });
}

const loginForm = document.getElementById("loginForm") 
const loginError = document.getElementById("loginError")

if (loginForm && loginError) {
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault()
        const formData = new FormData(loginForm)
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
                loginError.classList.remove("opacity1")
                setTimeout(() => {
                    loginError.innerHTML = data.message
                    loginError.classList.add("opacity1")
                }, 500);
            }
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        })
    })
}

const signUpForm = document.getElementById("signUpForm") 
const signUpError = document.getElementById("signUpError")

if (signUpForm && signUpError) {
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

const postForm = document.getElementById("postForm")
const postError = document.getElementById("postError")

if (postForm && postError) {
    postForm.addEventListener("submit", (e) => {
        e.preventDefault()
        const formData = new FormData(postForm)
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
            console.log(data.status)
            if (data.status === "ok") {

            } else {
                postError.classList.remove("opacity1")
                setTimeout(() => {
                    postError.textContent = data.message
                    postError.classList.add("opacity1")
                }, 500);
            }
        })
        .catch(error => {
            console.error(error)
        })
    })
}