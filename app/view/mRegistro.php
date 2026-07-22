<svg class="svg-dialog-close" id="closeModalRegistro" data-modal="registroModal" fill="#000000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve">
    <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
    c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
    c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
    c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
    l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
    c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
</svg>
<div id="card" class="card register-card">
    <h2>Crea tu cuenta</h2>
    <form class="register-form" action="" method="POST">
        <label> Nombre <br>
            <input type="text" name="nombre" required autocomplete="off">
        </label>
        <label> Contraseña <br>
            <input type="password" name="password" minlength="8" autocomplete="off" required>
        </label>
        <label>Uma Favorita <br>
        <select class="register-select" name="uma_fav" id="selectUmaFav">
            <option value="Mayano Top Gun">Mayano Top Gun</option>
            <option value="Narita Brian">Narita Brian</option>
        </select>
        </label>
        <input type="hidden" name="form" value="registro">
        <button type="submit">Registrar</button>
    </form>
    <p class="aviso"><?= isset($_SESSION["error_registro"]) ? e($_SESSION["error_registro"]) : ""; unset($_SESSION["error_registro"]) ?></p>
</div>
<a id="switchToLogin" class="a-switch-modal" href="#">
<svg class="svg-modal-switch" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.72 75.8">
    <path d="M1.5 75.8a1.5 1.5 0 0 1-1.06-2.56l33.56-33.56a2.53 2.53 0 0 0 0-3.56L.44 2.56A1.5 1.5 0 0 1 2.56.44l33.56 33.56a5.53 5.53 0 0 1 0 7.8L2.56 75.36A1.5 1.5 0 0 1 1.5 75.8z" fill="#000"/>
</svg>
Ya tienes una cuenta? <br> Inicia sesión!
</a>