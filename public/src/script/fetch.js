async function apiFetch(url, options = {}) {
    const response = await fetch(url, options);
    const result = await response.json().catch(() => null);

    if (!response.ok || !result || result.status !== "ok") {
        const errorMsg = result?.message || `${response.status}: ${response.statusText}`;
        throw new Error(errorMsg);
    }
    return result;
}

document.addEventListener("click", async (e) => {
    const likeAction = e.target.closest("[name='button-like']")
    const buttonComment = e.target.closest("[name='button-comment']")
    
    if (likeAction) {
        const postId = likeAction.dataset.postId
        const like = document.querySelector(`[name="likes"][data-post-id="${postId}"]`)
        const buttonLike = document.querySelector(`[name=button-like][data-post-id="${postId}"]`)
        
        try {
            const result = await apiFetch("api/posts/likes", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json" 
                },
                body: JSON.stringify({
                    data: postId
                })
            })
            
            const data = result.data
            
            console.log(`like dado, esta publicacion tiene: ${data.likes} like(s)`)
            
            like.innerHTML = data.likes
            
            if (data.like) console.log("diste like") 
            else console.log("dislike")

            if (buttonLike.classList.contains("liked")) {
                buttonLike.classList.remove("liked")
            } else {
                buttonLike.classList.add("liked")
            }
        } catch (error) {
            console.error(error)
        }
        return
    }

    if (buttonComment) {
        const postId = buttonComment.dataset.postId
        window.location.href = `post/${postId}`
    }
})

document.querySelector('[name="post_img"]')?.addEventListener("change", (e) => {
    document.getElementById('form-preview-img').src = 'src/media/img/post/' + e.target.value + '.webp'
})

const loginForm = document.getElementById("loginForm") 
const loginMessage = document.getElementById("loginMessage")

if (loginForm && loginMessage) {
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault()
        const formData = new FormData(loginForm)
        const datos = Object.fromEntries(formData.entries())
    
        try {
            const result = await apiFetch("api/auth/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(datos)
            })
            
            msg(loginMessage, result.message)
            setTimeout(() => {
                window.location.reload()
            }, 2000)
        } catch(error) {
            msg(loginMessage, error.message)
            console.error(error)
        }
    })
}

const signUpForm = document.getElementById("signUpForm") 
const signUpMessage = document.getElementById("signUpMessage")

if (signUpForm && signUpMessage) {
    signUpForm.addEventListener("submit", async (e) => {
        e.preventDefault()

        const formData = new FormData(signUpForm)
        const datos = Object.fromEntries(formData.entries())

        try {
            const result = await apiFetch("api/users", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(datos)
            })
            
            msg(signUpMessage, result.message)
            setTimeout(() => {
                window.location.reload()
            }, 2000)
        } catch (error) {
            msg(signUpMessage, error.message)
            console.error(error)
        }
    })
}

const postForm = document.getElementById("postForm")
const postMessage = document.getElementById("postMessage")

if (postForm && postMessage) {
    postForm.addEventListener("submit", async (e) => {
        e.preventDefault()
        const formData = new FormData(postForm)
        const datos = Object.fromEntries(formData.entries())

        try {
            const result = await apiFetch("api/posts", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(datos)
            })
        
            const data = result.data
            const postsWrap = document.querySelector(".post-wrapper")
            const newPost = crearPost(data)
        
            postsWrap.prepend(newPost) 
            postForm.reset()
        } catch(error) {
            msg(postMessage, error.message)
            console.error(error)
        }
    })
}

const commentForm = document.getElementById("commentForm")

if (commentForm) {
    commentForm.addEventListener("submit", async (e) => {
        e.preventDefault()

        const postId = commentForm.dataset.postId
        const formData = new FormData(commentForm)
        formData.append("postId", postId ?? "")
        const datos = Object.fromEntries(formData.entries())

        try {
            const result = await apiFetch("api/comment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(datos)
            })

            const data = result.data
            console.log(result.status + result.message)
            const commWrapper = document.querySelector(".comments-wrapper")
            const newComm = crearComentario(data)
            commWrapper.append(newComm)
            commentForm.reset()
        } catch (error) {
            console.log(error)
        }
    })
}

function msg(msgElement, data) {
    msgElement.classList.remove("op-1")
    setTimeout(() => {
        msgElement.textContent = data
        msgElement.classList.add("op-1")
    }, 500)
}

function crearPost(data) {
    const postDiv = document.createElement("div")
    postDiv.classList.add("post")

    const favUmaFormatted = (data.fav_uma || "").replace(/ /g, "_")

    postDiv.innerHTML = `
        <div class="post__title">
            <img class="post__title-img" src="src/media/img/pfp/${favUmaFormatted}_Pfp.webp" alt="">
            <h2 class="post__title-name capitalize"> 
                ${data.username} 
                <p class="post__title-date">${data.date}</p>
            </h2>
        </div>
        <div class="post__content">
            <p class="post__content-title">${data.title}</p>
            <p class="post__content-description">> ${data.content}</p>
            <img class="post__content-img" src="src/media/img/post/${data.post_img || "post_3"}.webp" alt="">
        </div>
        <div class="post__interaction">
            <button name="button-like" data-post-id="${data.id}" class="post__button-like">
                <svg class="post__interaction-like" viewBox="0 0 1024 1024" xmlns="http://w3.org">
                    <path class="svg-body" d="M254.6 740.2c-17.1 99.3-25.1 149.4 3.4 178 55.7 55.8 196.4-7 219-17.1 138.9-62.1 326.8-230 277.2-383.3-28-86.3-128.9-160.3-229.1-154.4-78.7 4.5-131.5 56.8-157.6 82.6-74.9 74.1-90 161.6-112.9 294.3z"/>
                    <path class="svg-shadow" d="M261.4 928.5c2.8 10 50.6 4.7 67.6 2.8 206.6-22.7 350.9-165.2 393.5-242.4.9-1.6 2.3-4.1 3.9-7.3 12.1-23.3 45.1-89.2 27.8-163.8-7.6-32.7-12.1-52-24-54.8-41.2-9.4-63 205.7-223.6 337.5-111 91.2-250 110.8-245.3 127.9z"/>
                    <polygon class="svg-body" points="606.8 535.8 678.5 604.5 678.5 604.5 606.8 535.8"/>
                    <polygon class="svg-body" points="579.3 648.7 614 682 614 682 579.3 648.7"/>

                    <g class="svg-leaves">
                        <path d="M584.1 84.8c-41.5.7-110.6 178.7-40.4 241.3 25 22.3 71.3 33.4 95.8 13.7 57.2-46-10-255.7-55.4-255z"/>
                        <path d="M653.6 319.9c-7.3 27.5 3.8 66.5 27.4 75.3 49.8 18.5 154.3-97.9 136.8-128.1-15.7-27.1-146.4-14.3-164.2 52.8z"/>
                    </g>
                    <g fill="#000000">
                        <path d="M316.7 962c-30.2 0-58.9-7.2-82.9-25.8-56.5-43.8-55.9-127.9-49.2-196.4 1.2-11.6 10.9-20.6 22.7-20.6 12.6 0 22.8 10.2 22.8 22.8 0 .8 0 1.6-.1 2.3-5.6 56.7-7.1 125.7 31.7 155.7 15 11.7 34.2 16.3 55.1 16.3 67 0 153.1-47.6 186.8-66.2 30.4-16.8 89.3-52.5 142.5-102.6 75.8-71.5 108.1-141.7 95.9-208.7-10.1-55.5-51.2-107.1-115.8-145.3-76.4-45.1-172.5-50.2-244.9-13-91.1 46.7-119 146.6-134.3 238.1-1.9 10.9-11.2 19-22.5 19-12.6 0-22.8-10.2-22.8-22.8 0-1.3.1-2.7.3-3.9 10.8-64.4 24.5-111.1 44.4-151.4 27.1-54.9 64.4-94.1 114.2-119.6 43.8-22.5 94.7-32.5 147.4-29.1 57.4 3.8 109.8 22.2 154.5 51.4 63.3 37.1 112.1 99.7 124.6 168.5 8.4 46.2.4 93.4-23.7 140.5-18.9 36.8-47.7 73.7-85.8 109.6-56.8 53.6-119.5 91.5-151.7 109.3-40.6 22.5-129.9 71.8-209 71.8z"/>
                        <path d="M215.1 702.2c0 0 0 0 0 0-12.6 0-22.8-10.2-22.8-22.8 0-1.1.1-2.2.2-3.2l.1-.9c1.6-11.2 11.1-19.7 22.6-19.7 12.6 0 22.8 10.2 22.8 22.8 0 1.1-.1 2.2-.2 3.2l-.1.9c-1.6 11.2-11.1 19.7-22.6 19.7z"/>
                        <path d="M606.4 372.9c-27.9 0-57.6-11.8-77.8-29.7-23.7-21.1-36.7-53.8-37.6-94.5-.8-31.7 5.8-67.8 18.4-101.7 9.4-25.3 35.5-84.3 74.5-84.9 16.9-.3 33.1 10.5 48.1 32 10.8 15.4 21.1 36.4 29.8 60.7 20.4 56.6 41.8 163-7.8 202.9-13.2 10.7-30 15.3-47.5 15.3zm-22-264.3c-3.9 2.9-11.8 11.1-21.1 28.9-10.4 20-18.9 45.3-23.3 69.4-8.5 46.7-1.5 84 19 102.3 19 17 53.1 23.6 66.3 12.9 9.4-7.6 17.9-33.9 10.8-83-7-46.2-21.9-87.7-43.5-124.9 6.3 9.5-3.7-1.9-8.3-5.6z"/>
                        <path d="M692.5 419.9c-.1 0-.2 0-.3 0-6.9 0-13.5-1.3-19.6-3.5-17.2-6.4-31.1-22.3-38.6-44.6-6.3-18.9-7.3-39.9-2.5-57.8 13.2-50.1 69.4-74.9 117.6-81.4 16.3-2.2 71-7 88.3 22.9 7.4 12.8 6.6 29.4-2.4 49.2-6.2 13.6-16.2 28.8-29.1 44-29.6 35.1-74.5 71.2-113.5 71.2zm81.9-143.4c-19 .1-37.1 3.7-53.9 10-13.1 4.7-39.2 17.1-44.9 39.2-5 19 3.5 44.5 13.3 48.1 4.6 1.7 18.6.1 41.9-16.6 34.3-25.4 61-59.2 77.3-98.5-18.1 36.2-13.5 25.7-11.9 20.3-4.6-1.4-12.2-2.5-21.8-2.5z"/>
                        <path d="M678.5 627.3c-6.1 0-11.7-2.4-15.8-6.4l-71.8-68.6c-4.5-4.2-7.3-10.1-7.3-16.7 0-12.6 10.2-22.8 22.8-22.8 6.2 0 11.9 2.5 16 6.5l71.8 68.7c4.3 4.2 7 10 7 16.5 0 12.6-10.2 22.8-22.8 22.8z"/>
                        <path d="M614 704.8c0 0-.1 0-.1 0-6.1 0-11.6-2.4-15.7-6.3l-34.7-33.2c-4.5-4.2-7.3-10.1-7.3-16.7 0-12.6 10.2-22.8 22.8-22.8 6.2 0 11.9 2.5 16 6.5l34.7 33.2c4.3 4.2 7 10 7 16.5 0 12.6-10.2 22.8-22.8 22.8z"/>
                    </g>
                </svg>   
                <p name="likes" data-post-id="${data.id}">0</p>
            </button>
        </div>
    `

    return postDiv
}

function crearComentario(data) {
    const postDiv = document.createElement("div")
    postDiv.classList.add("comment")

    const favUmaFormatted = (data.fav_uma || "").replace(/ /g, "_")

    postDiv.innerHTML = `
        <div class="comment__pfp">
            <a href="profile/${data.username}"> 
                <img class="comment__pfp-img" src="src/media/img/pfp/${favUmaFormatted}_Pfp.webp" alt="">
            </a>
        </div>
        <div class="comment__content">
            <a href="profile/${data.username}">
                <h2 class="comment__content-name capitalize"> 
                ${data.username}
                <span class="comment__content-date">Just Now</span>
                </h2>
            </a>
            <p class="comment__content-description">> ${data.content}</p>
        </div>
        <div class="comment__interaction">
            
        </div>
    `

    return postDiv
}