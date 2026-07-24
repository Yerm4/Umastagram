const buttonLike = document.querySelectorAll("[name=button-like]")

function msg(msg, data) {
    msg.classList.remove("opacity1")
    setTimeout(() => {
        msg.textContent = data.message
        msg.classList.add("opacity1")
    }, 500);
}

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
const loginMessage = document.getElementById("loginMessage")

if (loginForm && loginMessage) {
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
                msg(loginMessage, data)
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                msg(loginMessage, data)
            }
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        })
    })
}

const signUpForm = document.getElementById("signUpForm") 
const signUpMessage = document.getElementById("signUpMessage")

if (signUpForm && signUpMessage) {
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
                msg(signUpMessage, data)
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                msg(signUpMessage, data)
            }
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        })
    })
}

const postForm = document.getElementById("postForm")
const postMessage = document.getElementById("postMessage")

if (postForm && postMessage) {
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
                msg(postMessage, data)
            } else {
                msg(postMessage, data)
            }
        })
        .catch(error => {
            console.error(error)
        })
    })
}