<?php
    /*switch ($formulario) {

        case "registro":
            $nombreUsuario = trim($_POST["usuario"]);
            $password = trim($_POST["password"]);
            $umaFav = trim($_POST["umaFav"]);
            $umas_disponibles = ["Mayano Top Gun", "Narita Brian"];
            $umaFavIsOk = false;

            if (strlen($password) >= 8 && in_array($umaFav, $umas_disponibles)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                try {
                    $sql = "INSERT INTO usuarios (nombre, password, uma_fav) VALUES (:nombre, :password, :umafav)";
                    $stmt = $pdo->prepare($sql);
            
                    $stmt->execute([
                        "nombre" => $nombreUsuario,
                        "password" => $passwordHash,
                        "umafav" => $umaFav
                    ]);
        
                    $_SESSION["id_usuario"] = $pdo->lastInsertId();
                    $_SESSION["nombre_usuario"] = $nombreUsuario;
                    $_SESSION["uma_fav"] = $umaFav;
                    header("Location: perfil");
                    echo "ola";
                }
            
                catch (PDOException $e) {
                    $error = "Error. Una cuenta con ese nombre ya existe";
                    echo "ola";
                }
            }
        
            else {
                $aviso = "Hubo un error. Vuelvelo a intentar.";
                echo "ola";
            }
        break;
        
        default:
        header("Location: home");
        break;
    }
}
*/

$titulo = "Uma Musume";
include "header.php";
?>
        <main id="main" data-login='<?php echo isset($_SESSION["nombre_usuario"]) ? "true" : "false" ?>'>
            <section class="section-1" id="section-1">
                    <div class="relative-container">
                        <div id="dibujar" class="dibujar animacion-aparicion">
                        
                        </div>
                        <div class="IRL-button animacion-aparicion" id="switch-button" >
                            <svg class="caballo-svg" id="caballo-svg" viewBox="0 0 286.8 286.8" fill="#000" xmlns="http://www.w3.org/2000/svg">
                                <path d="M280.2 65c-.5-4.2-.2-8.3 0-12.7-1.7-1-1.1-3.3-1.9-5.3-.9 2.7.4 5.1.4 7.7-1.8-.4-1.7-2.2-2.9-2.9-.5 1.1-.5 2 .1 3.2.8 1.9 1.1 4 1.5 6 .6 3 1.1 6 1.6 9.1.1.7 0 1.4 0 2.2-.1 3.7 1.2 7.2 1.9 10.8 1.2 5.8 2.4 11.7 1.2 17.6-.7 3.5-2.1 6.5-5 8.8-.9.7-1.6 1.5-2.4 2.2-1.9 1.7-3.9 2.9-6.6 1.6-.9-.4-2-.4-3-.4-3.2 0-5.1-1.4-6.3-4.3-.9-2.1-1.7-4.1-1.2-6.5.1-.3-.1-.7-.2-1.1-1.7-4.6-3.4-9.2-6.2-13.3-1-1.5-1.7-3.4-2.4-5.1-1.2-2.7-2.7-5.1-4.9-7.1-2.1-1.9-4-3.9-4.3-7-.1-.3-.2-.7-.5-1.4-.9 1.3-1.9 2.2-2.4 3.4-2.8 5.8-5.6 11.5-8.3 17.4-1.6 3.4-3 6.9-4.3 10.4-.5 1.4-.8 2.9-.8 4.4.1 6.8.4 13.5 1.4 20.3.5 3.5-.4 7-2.3 9.9-3.7 5.4-6.7 11.3-11.5 15.8-.9.8-1 1.7-.5 2.8 2.1 5.4 4.1 10.9 6.4 16.2 1.3 3.1 3 5.9 4.5 8.9 2 3.7 4 7.3 6 11 .3.7.5 1.5.5 2.3 0 3-.1 6-.2 9.1-.1 1.8-.7 3.4-1.9 4.8-2.4 2.8-4.1 6-5.7 9.3-1.9 4.1-4.1 8.1-5.8 12.3-3 7.6-1.4 5.3-7.3 10.7-2.7 2.5-4.5 5.5-6.1 8.7-.5 1.1-1.2 2.1-2.1 2.9-1.6 1.7-3.4 3.3-5.1 4.9-2.8 2.6-2.9 5.1-.7 8.2 1.3 1.8 2.2 3.9 3.3 5.7-.3 1.1-1 1.3-1.8 1.5-.8.2-1.7.3-2.5.2-4.2-.1-8.5-.3-12.7-.5-1.3-.1-4.4-2.6-4.7-3.9-.6-2.8-1.8-5.4-3.4-7.7-.6-.8-1.1-1.6-1.6-2.5-1.3-2.3-1.7-4.6-.7-7.3.7-2 1-4.1 1.2-6.2.5-4 1-8 1.3-12.1.3-4.3.5-8.6.5-12.9 0-2.1-.5-4.3-1.2-6.4-.7-2.3-.9-4.7-.5-7 .7-4.4.5-8.8.3-13.2-.2-5.6-.8-11.1-1.2-16.7-.3-3.7-.5-7.4-.8-11-.2-1.9-.3-1.8-2.2-1.7-2.6.2-5.2.4-7.8.5-8 .2-16.1.4-24.1.4-6.1.1-12.1-.6-18-2.1-1.9-.5-3.7-1-5.6-1.4-5.6-1.4-10.6-4.2-15.4-7.2-1.1-.7-2.3-1.4-3.4-2.1-.7-.4-1.3-.5-1.6.4-2.4 5.5-5.2 10.8-6.6 16.7-1 4.1-1.6 8.3-2.4 12.5-.2 1.1-.5 2.1-.9 3.1-1.3 3.3-2.8 6.4-3.9 9.7-.6 1.7-.8 3.7-.9 5.5-.2 4-1.3 7.7-2.9 11.4-.8 1.9-1.2 3.8-.8 5.8 1.3 6 2.5 12 3.8 17.9.7 3 1.4 6 2.5 8.9 1.6 4.2 3.2 8.4 6 12 .6.8 1.3 1.4 2 2.1 1.8 1.9 3.6 3.8 5.3 5.7 1.4 1.5 2.1 3.4 2.5 5.4.3 1.6.2 2.1-1.4 2.3-2.1.3-4.3.4-6.5.4-3 0-6-.3-9.1-.3-1 0-1.8-.3-2.3-1.1-1.6-2.2-3.4-4.4-4.7-6.8-.9-1.7-1.1-3.7-1.6-5.5-.7-2.6.3-5.1-.4-7.6-.4-1.4-.4-2.6-.8-4-.4-1.4-.5-2.9-1-4.2-1.7-4.6-3.1-9.5-3.9-14.3-.6-3.4-1.3-5.9-2-9.3-.4-1.7-1.1-4-1.8-6.4-.1-.2-.2-.5-.3-.8-.9-2.6-1.8-5.3-2.7-7.9-.7-2.1-.5-4.1 0-6.3 1.3-5.4 2.5-10.8 3.7-16.3.4-1.9.6-3.8.8-5.7.4-3.8-.3-7.5-1.7-11-.2-.4-.2-.9-.4-1.4-.6-1.4-1.2-2.9-2-4.3-1.4-2.3-2.1-2.2-3.6 0-.5.8-.9 1.7-1.5 2.5-.8 1.3-1.7 2.6-2.6 3.9-1.6 2.2-3.1 4.3-3.9 6.9-.6 1.8-1.8 3.3-2.5 5-1.5 3.9-2.9 8-4.3 11.9-.9 2.6-1.5 5.2-1.1 8 .1 1.1-.4 2.4-.9 3.4-1.1 2.4-2.3 4.7-3.4 7 0 .2-.1.4-.2.5-4.3 6.8-4.3 14.6-5 22.2-.4 4.4-.3 8.8.4 13.2.1.9 0 1.9 0 2.9-.3 3.5 0 6.9 2.1 9.9.8 1.1 1.1 2.5 1.6 3.8.8 2.3 1.6 4.7 2.4 7.1.5 1.6.4 2-1.1 2.7-3.6 1.8-7.3 2.4-11.3 1.8-1.2-.2-2.5-.5-3.7-.9-1-.3-1.4-1-1.3-2.1.3-2.8.5-5.7.8-8.5v-.9c.8-1.4.7-2.9.3-4.4-.7-3-1.5-6-2.1-9-.2-.9-.2-1.8 0-2.7.9-4.6 2.1-9.2 2.9-13.8.6-3.1.8-6.2 1.1-9.4.4-4.1.4-8.2.1-12.3-.2-2 .2-4.1.6-6.1.4-2.1.6-4.1.2-6.1-.3-1.6-.4-3.3-.4-4.9 0-1.6.5-3 1.2-4.5 1.7-3.4 3.6-6.7 3.4-10.7 0-1.2 0-2.3-1.4-2.9-.2-.1-.4-.3-.5-.5-2.1-3.9-5.7-6.6-8.5-9.9-2.8-3.2-5-6.7-6.8-10.5-.3-.7-.6-1.3-1.4-1.7-.7-.3-1.1-1.2-1.7-1.9-2.6-3.4-3.9-7.3-4.1-11.5-.2-3.9.3-7.7.4-11.6.1-3.7.1-7.5.2-11.3 0-.9.3-1.9.6-2.8.5-1.3.9-2.6.6-4-.3-1.4.2-2.8 1.1-4.1.9-1.3 1.4-2.9 2-4.4.6-1.3 1-2.7 1.7-4 .5-1.1 1.2-2.1 1.9-3.1 1-1.4 2-2.7 3.2-3.9 1-1.1 2-2.2 2.6-3.7.2-.7.8-1.3 1.4-1.8 1.5-1.1 2.9-2.3 4.2-3.7 1-1.2 3-1.9 4.7-2 3.7-.2 7.5.1 11.2.2 3.1.1 6.1-.2 9.1-1.4 5.2-2.1 10.5-4.1 15.8-6.1 2.9-1.1 5.9-1.3 8.9-1.2 11 .5 22 1.6 32.6 4.9 9.9 3.1 20 4.9 30.4 4.8 3.2 0 6.4-.6 9.6-.9.3 0 .6-.1.9-.2 3-1.5 6-2.9 8.9-4.5.8-.4 1.2-1.4 1.9-2.1.9-1 1.8-2 2.7-2.9.8-.7 1.8-1.2 2.6-2 3.5-3.7 8.1-4.6 12.8-4.6 4.8.1 9.1-1.5 13.3-3.4 1.9-.8 3.4-2.5 4.9-4 3.3-3.1 6.8-5.8 10.4-8.5 5-3.5 9.7-7.5 14.7-11 4.1-2.9 8.6-5.2 13.2-7.2 3.7-1.7 7.6-1.9 11.5-2.1 3.7-.2 7.3-.2 11 .3 2.7.3 5.4-.2 8.2-.2s5.5-.2 8.1.2c1.6.2 3.1 1.3 4.5 2.2 2.3 1.6 3.8 1.7 6.2.3 1.9-1.2 3.8-2.3 5.8-3.4.5-.3 1.2-.4 1.7-.4 1.5.1 1.9 1 1.4 2.3-.5 1.3-.8 2.7-1.1 4-.4 1.7-.9 3.2-2.5 4.2-2.1 1.3-2.3 2.9-1.4 5.2.8 2 1.5 4 2.2 5.9.8 2.1.6 4.2.2 6.3-.4 2.5-.7 5-1 7.5-.1.6-.1 1.3-.4 1.8-.4 2.9-.9 6.1-1.3 9.3zm-94.4 188.7v-1.5c-.1-1.2-.2-2.4-.2-3.6-.1-1.9-.1-3.9-.1-5.8 0-.8-.2-1.6-.1-2.4.2-1.6.5-3.1 2.3-3.8 1.3-.5 2.1-2 3.7-2.2 2.2-.3 3.4-1.6 4.3-3.7.8-2.1 2-4.2 3.3-6 1.5-2.2 3.5-4 5.1-6.1 4.1-5.2 7.3-10.9 9.6-17.2 1.6-4.4.5-8.3-2.2-11.7-1.7-2.2-3.9-4-5.8-5.9-1.8-1.7-3.7-3.3-5.3-5.2-2.9-3.6-5.6-7.4-8.5-11.1-.6-.7-1.2-1.4-2.1-2.5-.4 1.5-.7 2.6-.8 3.6-.4 2.6-.6 5.3-1.1 7.9-1.1 6.3-2.3 12.5-2.6 18.9-.1 1.6-.3 3.2 0 4.7 1 5.5.5 10.8-2 15.9-.9 1.9-1.5 4-1.9 6-.5 3-.7 6.1-1 9.2-.3 3.8-.5 7.6.6 11.4.8 2.8 1.7 5.5 2.6 8.3 1.1.2 1.6 1.2 3 1.9zM21 136.7c-2 2.9 1.1 16.4 4.7 18.4-1.9-6.3-4.9-11.9-4.7-18.4z" />
                            </svg>
                            <svg class="uma-svg" id="uma-svg" viewBox="0 0 48 48" fill="none" stroke="#000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="21.5"/>
                                <path d="M39.65 17.791c-2.81-8.474-10.024-9.886-11.421-10.304-1.397-.418-4.872-.548-6.581.089-5.242 2.013-8.277 7.948-8.277 7.948-1.209.642-3.888 4.743-3.44 9.445-.457-1.038-1.604-1.661-1.604-1.661"/>
                                <path d="M32.116 14.225c.991 2.402-.106 13.083-2.121 17.875-2.015 4.792-4.891 6.994-4.891 6.994"/>
                                <path d="M3.865 16.461c2.444 1.779 2.115 5.484 4.462 6.848.539 4.498-1.748 6.458-4.968 6.69"/>
                                <path d="M4.169 32.29s3.573-.484 4.768-1.908c1.996-2.377.994-5.413.994-5.413 0 0 1.036-.565 3.416.463 1.32 1.643 1.222 4.25 1.064 5.578-.17 1.425-3.5 7.54-6.67 7.026"/>
                                <path d="M21.086 35.53c3.042-.045 8.506-2.539 8.506-2.539M15.792 29.966s3.562 4.614 5.294 5.564"/>
                                <path d="M25.185 30.245c-.538-1.175-3.175-2.081-5.392-1.223-.383 2.1-.068 4.437 1.825 4.739 1.894.302 3.415-1.416 3.567-3.516Z"/>
                                <path d="M21.265 21.848c-2.559-3.661-4.891.289-5.418 1.34l.475.858"/>
                                <path d="M27.038 23.189c3.914-1.861 4.577 1.543 4.309 3.388l-.928 1.032"/>
                                <path d="M21.648 7.577s.3-2.769-.368-3.227c-.668-.458-2.747 1.812-3.848 3.664-.979.922-3.12-.267-4.501 1.22.378 1.054 2.634 3.054 2.634 3.054"/>
                                <path d="M23.342 25.878l-.198.598"/>
                                <path d="M15.683 27.723c-.383 4.198 2.867 8.83 3.474 9.126-1.764-.575-3.868-2.845-4.768-5.691"/>
                                <path d="M32.554 9.127C39.158 15.631 42.066 35.345 25.104 39.094"/>
                                <path d="M34.864 38.015c4.74-2.406 6.516-8.087 5.076-15.741"/>
                                <path d="M35.282 11.017c.682-1.437 2.751-1.625 2.751-1.625l1.13-.581"/>
                                <path d="M41.466 11.487c-.979 2.215-2.555 3.438-3.147 3.283"/>
                                <path d="M15.709 33.881c.273 4.656-1.781 9.09-1.781 9.09"/>
                                <path d="M19.157 36.849l.538 2.802 5.315-4.905"/>
                                <path d="M16.52 43.872c-.01-.809.6 2.797 3.175-4.222-1.212 2.275-.827 4.291-.827 4.291"/>
                                <path d="M19.695 39.651c2.927 8.783 10.207 1.736 0 0"/>
                                <path d="M25.93 34.454c1.044.766 1.081 2.668 1.081 2.668"/>
                                <path d="M27.217 39.068c.34 1.713-.023 6.194-.023 6.194"/>
                                <path d="M27.217 39.068c2.5 .004 3.212 1.886 3.019 2.777-.218 1.004.678 2.493.678 2.493"/>
                                <path d="M30.752 36.992c1.526.739-.406 3.044 3.289 6.021"/>
                                <path d="M36.956 16.852c3.582-.05 4.204 3.497 3.853 4.473-.352.975-2.148 1.81-3.055.669"/>
                                <path d="M14.984 8.418c-1.498-6.482 3.612-4.255 4.408-3.009"/>
                                <path d="M28.399 17.45c.026 1.252-.055 2.507-.314 3.639 3.63-3.817 2.395-11.496.144-13.602-4.702.653-9.889 7.91-11.389 12.582 1.16-1.988 6.825-6.142 8.569-8.343.094 1.292-1.786 7.753-3.416 10.748 3.466-.568 5.022-2.085 6.337-4.852"/>
                                <path d="M13.371 15.525c-1.753-1.36.55-4.792 2.194-3.237"/>
                                <path d="M13.347 25.432c-.546-3.654.927-7.05 1.127-7.05"/>
                            </svg>
                        </div>
                    </div>
                
                <div class="buscador-container">
                    <form onsubmit="buscarUmaForm(event)">
                        <input type="text" list="sugerencias-umas" id="nombreUma" placeholder="Nombre de la Uma..." class="buscador" autocomplete="off">
                        <button onclick="buscarUma()" class="buscador-button">Buscar</button>
                        <datalist id="sugerencias-umas">
                        </datalist>
                    </form>
                </div>
    
                <div id="context-menu" class="context-menu context-menu-animacion">
                    
                </div>

            </section>
                
            <section class="section-2">
                <div>
                    <h2>Lista de Umas disponibles (Puedes <strong>clickearlas</strong>) </h2>
                    <div class="umas-disponibles" id="umas-disponibles">
                        
                    </div>
                </div>
            </section>
            <section class="section-3">
                
            </section>
        </main>

        <dialog id="registroModal">
        
            <svg class="svg-dialog-close" id="closeModalRegistro" fill="#000000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve">
                <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
                c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
                c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
                c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
                l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
                c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
            </svg>
            <div id="card" class="card register-card">
                <h1>Crea tu cuenta</h1>
                <form class="register-form" action="" method="POST">
                    <label> Nombre <br>
                        <input type="text" name="usuario" required autocomplete="off">
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
                <p class="aviso"><?= isset($_SESSION["error_registro"]) ? e($_SESSION["error_registro"]) : ""; ?> <br> <?= isset($error) ? e($error) : ""?></p>
            </div>
            <a id="switchToLogin" class="a-switch-modal" href="#">
            <svg class="svg-modal-switch" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.72 75.8">
                <path d="M1.5 75.8a1.5 1.5 0 0 1-1.06-2.56l33.56-33.56a2.53 2.53 0 0 0 0-3.56L.44 2.56A1.5 1.5 0 0 1 2.56.44l33.56 33.56a5.53 5.53 0 0 1 0 7.8L2.56 75.36A1.5 1.5 0 0 1 1.5 75.8z" fill="#000"/>
            </svg>
            Ya tienes una cuenta? <br> Inicia sesión!
            </a>
        </dialog>

        <dialog id="loginModal">

            <svg class="svg-dialog-close" id="closeModalLogin" fill="#000000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve">
                <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
                c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
                c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
                c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
                l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
                c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
            </svg>
            <div id="card" class="card login-card">
                <h1>Iniciar Sesión</h1>
                <form class="login-form" action="" method="POST">
                    <label> Usuario <br>
                        <input type="text" name="usuario" required>
                    </label>
                    <label> Contraseña <br>
                        <input type="password" name="password" autocomplete="off" required>
                    </label>
                    <input type="hidden" name="form" value="login">
                    <button type="submit">Loguear</button>
                </form>
                <p class="aviso"><?= isset($_SESSION["error_login"]) ? e($_SESSION["error_login"]) : ""; ?> <br> <?= isset($error) ? e($error) : ""?></p>
            </div>
            <a href="#" class="a-switch-modal" id="switchToRegistro">
            <svg class="svg-modal-switch" viewBox="0 0 75.803 75.803" xmlns="http://www.w3.org/2000/svg">
                <path d="M36.231,0a1.5,1.5,0,0,1,1.06,2.561L3.735,36.121a2.528,2.528,0,0,0,0,3.564L37.291,73.243a1.5,1.5,0,0,1-2.121,2.121L1.616,41.806a5.527,5.527,0,0,1,0-7.807L35.172,2.561A1.5,1.5,0,0,1,36.231,0Z" fill="#000"/>
            </svg>
            No tienes una cuenta aún? <br> Registrate!
            </a>

        </dialog>

        <footer>
            <p>Este es un proyecto sin fines de lucro creado por un fan. Todos los derechos de los personajes e imágenes pertenecen a Cygames. No tengo afiliación oficial con el juego.</p>
            <p>This is a non-profit fanmade project. All characters and images are property of Cygames. I have no official afilitaion with the game nor their developers.</p>
            
            <script src="src/script/datos.js" defer></script>
            <script src="src/script/index.js" defer></script>
        </footer>

        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
    </div>
</body>
</html>