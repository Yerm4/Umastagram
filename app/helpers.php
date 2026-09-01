<?php 
declare(strict_types=1);

function e(?string $string) : string {
    if ($string === null) {
        return "";
    }
    return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}

function toUnderscore(?string $string) : string {
    if ($string === null) {
        return "";
    }
    return str_replace(" ", "_", $string);
}

function webpExists(?string $file, string $path = "/src/media/img/post/") : bool {
    if (empty($file)) {
        return false;
    }
    return file_exists(__DIR__."/../public".$path.$file.".webp");
}

function code(?int $num = null) {
    if ($num === null) {
        return http_response_code();
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

function getRelativeTime(string $pastTimeString) : string { 
    $timezonePost = new DateTimeZone('Etc/GMT+7'); 
    $pastTime = new DateTimeImmutable($pastTimeString, $timezonePost); 
    $currentTime = new DateTimeImmutable('now', $timezonePost); 
    $diff = $currentTime->diff($pastTime); 

    if ($diff->y > 0) {
        return "Hace " . $diff->y . ($diff->y == 1 ? " año" : " años");
    }
    if ($diff->m > 0) {
        return "Hace " . $diff->m . ($diff->m == 1 ? " mes" : " meses");
    }
    if ($diff->d > 0) {
        return "Hace " . $diff->d . ($diff->d == 1 ? " día" : " días");
    }
    if ($diff->h > 0) {
        return "Hace " . $diff->h . ($diff->h == 1 ? " hora" : " horas");
    }
    if ($diff->i > 0) {
        return "Hace " . $diff->i . ($diff->i == 1 ? " minuto" : " minutos");
    } 

    return 'Justo ahora'; 
}

function getUmaImage(string $umaName, int $index = 0): string {
    static $establo = null;

    if ($establo === null) {
        $file = __DIR__ . "/data/datos.php";
        $establo = file_exists($file) ? require $file : [];
    }

    return $establo[$umaName]["imagen"][$index] ?? $establo[$umaName]["imagen"][0] ?? "Mayano_Top_Gun_Alt(3).webp";
}
