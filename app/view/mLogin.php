<svg class="svg-dialog-close" id="closeModalLogin" data-modal="loginModal" fill="#000000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve">
    <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
    c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
    c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
    c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
    l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
    c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
</svg>
<div id="card" class="card login-card">
    <h2>Inicio de Sesión</h2>
    <form class="login-form" action="" method="POST">
        <label> Usuario <br>
            <input type="text" name="nombre" required>
        </label>
        <label> Contraseña <br>
            <input type="password" name="password" autocomplete="off" required>
        </label>
        <input type="hidden" name="form" value="login">
        <button type="submit">Loguear</button>
    </form>
    <p class="aviso"><?php echo isset($_SESSION["error_login"]) ? e($_SESSION["error_login"]) : ""; unset($_SESSION["error_login"]) ?></p>
</div>
<a href="#" class="a-switch-modal" id="switchToRegistro">
<svg class="svg-modal-switch" viewBox="0 0 75.803 75.803" xmlns="http://www.w3.org/2000/svg">
    <path d="M36.231,0a1.5,1.5,0,0,1,1.06,2.561L3.735,36.121a2.528,2.528,0,0,0,0,3.564L37.291,73.243a1.5,1.5,0,0,1-2.121,2.121L1.616,41.806a5.527,5.527,0,0,1,0-7.807L35.172,2.561A1.5,1.5,0,0,1,36.231,0Z" fill="#000"/>
</svg>
No tienes una cuenta aún? <br> Registrate!
</a>