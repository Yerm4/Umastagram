const queryMobile = window.matchMedia("(pointer: fine)").matches;



// Login

const modales = document.querySelectorAll("dialog[name=modal]")
const modalesButton = document.querySelectorAll("[name=buttonModal]")

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
    if (switchToRegistro) {
        switchToRegistro.addEventListener("click", function(event) {
        event.preventDefault();
        loginModal.classList.add("modal-fade");
        setTimeout(() => {
            loginModal.classList.remove("modal-fade");
            loginModal.close();
            registroModal.showModal();
        }, 1500);
    })
}

const switchToLogin = document.getElementById("switchToLogin");

if (switchToLogin) {
    switchToLogin.addEventListener("click", function(event) {
        event.preventDefault();
        registroModal.classList.add("modal-fade");
        setTimeout(() => {
            registroModal.classList.remove("modal-fade");
            registroModal.close();
            loginModal.showModal();
        }, 1500);
    });
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