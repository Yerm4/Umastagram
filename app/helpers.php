<?php 
function e($texto) {
    if ($texto === null) {
        return "";
    }
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function reload() {
    $url = $_SERVER["REQUEST_URI"];
    header("Location: ".$url);
    die();
}

function umaGuion($texto) {
    if ($texto === null) {
        return "";
    }
    return str_replace(" ", "_", $texto);
}

function webpExists(string $file, string $ruta = "/src/media/img/post/") : bool {
    if (empty($file)) {
        return false;
    }

    return file_exists(__DIR__."/../public".$ruta.$file.".webp");
}

function code($num) {
    if ($num === null) {
        return "";
    }
    return http_response_code($num);
}

function cleanString($value): ?string {
    if (!is_string($value) && !is_int($value) && !is_float($value)) {
        return null; 
    }

    $trimmed = trim((string)$value);
    return $trimmed !== '' ? $trimmed : null;
}


function cleanValue(?array $data, string $key): ?string {
    return cleanString($data[$key] ?? null);
}

function getRelativeTime($pastTimeString) {
    $timezonePost = new DateTimeZone('Etc/GMT+7');
    $pastTime = new DateTimeImmutable($pastTimeString, $timezonePost);
    
    $currentTime = new DateTimeImmutable('now', $timezonePost);
    
    $diff = $currentTime->diff($pastTime);
    
    if ($diff->y > 0) return "Hace ".$diff->y." años";
    if ($diff->m > 0) return "Hace ".$diff->m." meses";
    if ($diff->d > 0) return "Hace ".$diff->d." dias";
    if ($diff->h > 0) return "Hace ".$diff->h." horas";
    if ($diff->i > 0) return "Hace ".$diff->i." minutos";
    
    return 'Justo ahora';
}


function getUmaImage(string $umaName, int $index = 0): string {
    static $establo = null;

    if ($establo === null) {
        $rutaArchivo = __DIR__ . "/data/datos.php";
        $establo = file_exists($rutaArchivo) ? require $rutaArchivo : [];
    }

    return $establo[$umaName]["imagen"][$index] ?? $establo[$umaName]["imagen"][0] ?? "Mayano_Top_Gun_Alt(3).webp";
}

