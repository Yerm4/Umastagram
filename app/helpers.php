<?php
declare(strict_types=1);

/*
 * ============================================================================
 * ÍNDICE RÁPIDO DE FUNCIONES
 * ============================================================================
 * --- UTILIDADES GENERALES Y VISTAS ---
 * e()
 * toUnderscore()
 * webpExists()
 * code()
 * getRelativeTime()
 * getUmaImage()
 * getJsonInput()
 *
 * --- VALIDACIÓN DE VARIABLES INDIVIDUALES ---
 * parseInt()
 * parsePositiveInt()
 * parseFloat()
 * isValidNumber()
 * parseBool()
 * parseString()
 * parseEmail()
 * parseDate()
 *
 * --- LIMPIEZA DIRECTA DESDE ARRAYS ($_POST, $_GET, JSON) ---
 * cleanValue()
 * cleanInt()
 * cleanPositiveInt()
 * cleanFloat()
 * cleanBool()
 * cleanEmail()
 * cleanDate()
 *
 * ============================================================================
 * DESCRIPCIÓN DETALLADA Y ADVERTENCIAS
 * ============================================================================
 * --- UTILIDADES GENERALES Y VISTAS ---
 * - e(): Escapa caracteres especiales para HTML seguro (string). Cuidado: úsalo siempre al imprimir datos de usuarios en la vista para evitar ataques XSS; acepta null devolviendo "".
 * - toUnderscore(): Quita espacios de los extremos y reemplaza uno o más espacios internos por un solo guion bajo (string). Cuidado: no elimina tildes ni caracteres especiales.
 * - webpExists(): Comprueba si existe un archivo .webp en la ruta pública indicada (bool). Cuidado: usa basename() por seguridad, así que ignora subcarpetas si las pasas en $file; no incluyas la extensión ".webp".
 * - code(): Establece y/o devuelve el código de respuesta HTTP actual (int). Cuidado: debe llamarse antes de imprimir cualquier texto o JSON (echo).
 * - getRelativeTime(): Convierte una fecha en texto relativo como "Hace 5 minutos" (string). Cuidado: usa la zona horaria fija 'Etc/GMT+7' y devuelve 'Justo ahora' si la fecha es futura o menor a 1 minuto.
 * - getUmaImage(): Obtiene la ruta de imagen de una Uma desde datos.php usando caché estática en memoria (string). Cuidado: si no encuentra el personaje o índice, devuelve "Mayano_Top_Gun_Alt(3).webp" por defecto.
 * - getJsonInput(): Lee el cuerpo crudo de una petición (php://input) y lo decodifica a un array seguro (array). Cuidado: si el JSON está vacío o mal formado, devuelve [] sin lanzar errores.
 *
 * --- VALIDACIÓN DE VARIABLES INDIVIDUALES ---
 * - parseInt(): Convierte y valida un entero (?int). Cuidado: rechaza decimales ("12.5") y texto mezclado ("15px"), pero acepta 0 y "0".
 * - parsePositiveInt(): Igual que parseInt(), pero exige que el número sea mayor a 0 (?int). Cuidado: devuelve null para 0 y negativos; ideal para IDs de base de datos.
 * - parseFloat(): Convierte y valida un decimal (?float). Convierte enteros como "10" en 10.0. Cuidado: exige punto decimal (.), rechaza comas (,).
 * - isValidNumber(): Comprueba si un dato es entero o decimal válido (bool). Cuidado: devuelve false para booleanos (true/false), a diferencia de is_numeric() nativo.
 * - parseBool(): Convierte y valida booleanos reales (?bool). Entiende "false", "0", "off" como false. Cuidado: devuelve null si envían basura como "hola".
 * - parseString(): Limpia espacios con trim() y convierte números o textos a string (?string). Cuidado: protege el "0" para que no se pierda, pero devuelve null si queda vacío o recibe arrays/objetos.
 * - parseEmail(): Limpia espacios, pasa a minúsculas y valida formato de correo (?string). Cuidado: solo valida sintaxis, no comprueba si el buzón existe.
 * - parseDate(): Valida una fecha estricta según el formato indicado, por defecto YYYY-MM-DD (?string). Cuidado: rechaza fechas imposibles como "2026-02-30".
 *
 * --- LIMPIEZA DIRECTA DESDE ARRAYS ($_POST, $_GET, JSON) ---
 * - cleanValue(): Extrae una clave de un array y la limpia con parseString() (?string). Cuidado: devuelve null si la clave no existe o está vacía.
 * - cleanInt(): Extrae una clave de un array y la valida con parseInt() (?int). Cuidado: protege el 0, devuelve null si la clave no existe o no es entero.
 * - cleanPositiveInt(): Extrae una clave de un array y la valida con parsePositiveInt() (?int). Cuidado: ideal para leer IDs directo de $_GET o JSON; devuelve null si es <= 0.
 * - cleanFloat(): Extrae una clave de un array y la valida con parseFloat() (?float). Cuidado: devuelve null si no es un número decimal o entero válido.
 * - cleanBool(): Extrae una clave de un array y la valida con parseBool() (?bool). Cuidado: distingue correctamente entre false real y clave ausente (null).
 * - cleanEmail(): Extrae una clave de un array y la valida con parseEmail() (?string). Cuidado: devuelve null si el correo tiene formato inválido.
 * - cleanDate(): Extrae una clave de un array y la valida con parseDate() (?string). Cuidado: acepta un tercer parámetro opcional para cambiar el formato de fecha.
 * ============================================================================
 */

// ============================================================================
// UTILIDADES GENERALES Y VISTAS
// ============================================================================

function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function toUnderscore(?string $string): string {
    if ($string === null) {
        return '';
    }
    return preg_replace('/\s+/', '_', trim($string)) ?? '';
}

function webpExists(?string $file, string $path = '/src/media/img/post/'): bool {
    if ($file === null || trim($file) === '') {
        return false;
    }
    $safeFile = basename($file);
    $cleanPath = '/' . trim($path, '/') . '/';
    
    return is_file(__DIR__ . '/../public' . $cleanPath . $safeFile . '.webp');
}

function code(?int $num = null): int {
    if ($num !== null) {
        http_response_code($num);
    }
    $current = http_response_code();
    return is_int($current) ? $current : 200;
}

function getRelativeTime(?string $pastTimeString): string { 
    if ($pastTimeString === null || trim($pastTimeString) === '') {
        return 'Fecha desconocida';
    }

    try {
        $timezonePost = new DateTimeZone('Etc/GMT+7'); 
        $pastTime = new DateTimeImmutable($pastTimeString, $timezonePost); 
        $currentTime = new DateTimeImmutable('now', $timezonePost); 
    } catch (Exception $e) {
        return 'Fecha inválida';
    }

    $diff = $currentTime->diff($pastTime); 

    if ($diff->invert === 0) {
        return 'Justo ahora';
    }

    if ($diff->y > 0) {
        return 'Hace ' . $diff->y . ($diff->y === 1 ? ' año' : ' años');
    }
    if ($diff->m > 0) {
        return 'Hace ' . $diff->m . ($diff->m === 1 ? ' mes' : ' meses');
    }
    if ($diff->d > 0) {
        return 'Hace ' . $diff->d . ($diff->d === 1 ? ' día' : ' días');
    }
    if ($diff->h > 0) {
        return 'Hace ' . $diff->h . ($diff->h === 1 ? ' hora' : ' horas');
    }
    if ($diff->i > 0) {
        return 'Hace ' . $diff->i . ($diff->i === 1 ? ' minuto' : ' minutos');
    } 

    return 'Justo ahora'; 
}

function getUmaImage(string $umaName, int $index = 0): string {
    static $establo = null;

    if ($establo === null) {
        $file = __DIR__ . '/data/datos.php';
        $establo = is_file($file) ? require $file : [];
    }

    return $establo[$umaName]['imagen'][$index] 
        ?? $establo[$umaName]['imagen'] 
        ?? 'Mayano_Top_Gun_Alt(3).webp';
}

function getJsonInput(): array {
    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $jsonData = json_decode($raw, true);
    return is_array($jsonData) ? $jsonData : [];
}

// ============================================================================
// VALIDACIÓN DE VARIABLES INDIVIDUALES
// ============================================================================

function parseInt($value): ?int {
    if (is_bool($value) || is_array($value) || is_object($value) || $value === null) {
        return null;
    }

    if (is_int($value)) {
        return $value;
    }

    if (is_string($value)) {
        $value = trim($value);
        if ($value === '') {
            return null;
        }
    }

    $filtered = filter_var($value, FILTER_VALIDATE_INT);
    return $filtered !== false ? $filtered : null;
}

function parsePositiveInt($value): ?int {
    $int = parseInt($value);
    return ($int !== null && $int > 0) ? $int : null;
}

function parseFloat($value): ?float {
    if (is_bool($value) || is_array($value) || is_object($value) || $value === null) {
        return null;
    }

    if (is_float($value) || is_int($value)) {
        return (float) $value;
    }

    if (is_string($value)) {
        $value = trim($value);
        if ($value === '') {
            return null;
        }
    }

    $filtered = filter_var($value, FILTER_VALIDATE_FLOAT);
    return $filtered !== false ? $filtered : null;
}

function isValidNumber($value): bool {
    return parseFloat($value) !== null;
}

function parseBool($value): ?bool {
    if (is_array($value) || is_object($value) || $value === null) {
        return null;
    }

    if (is_bool($value)) {
        return $value;
    }

    if (is_string($value)) {
        $value = trim($value);
        if ($value === '') {
            return null;
        }
    }

    return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
}

function parseString($value): ?string {
    if (is_array($value) || is_object($value) || is_bool($value) || $value === null) {
        return null;
    }

    $clean = trim((string) $value);
    return $clean !== '' ? $clean : null;
}

function parseEmail($value): ?string {
    $clean = parseString($value);
    if ($clean === null) {
        return null;
    }

    $filtered = filter_var($clean, FILTER_VALIDATE_EMAIL);
    return $filtered !== false ? strtolower($filtered) : null;
}

function parseDate($value, string $format = 'Y-m-d'): ?string {
    $clean = parseString($value);
    if ($clean === null) {
    return null;
    }
    $date = DateTime::createFromFormat($format, $clean);
    if ($date !== false && $date->format($format) === $clean) {
    return $clean;
    }
    return null;
    }
    // ============================================================================
    // LIMPIEZA DIRECTA DESDE ARRAYS ($_POST, $_GET, JSON)
    // ============================================================================
function cleanValue(?array $data, string $key): ?string {
    return parseString($data[$key] ?? null);
}
function cleanInt(?array $data, string $key): ?int {
    return parseInt($data[$key] ?? null);
}
function cleanPositiveInt(?array $data, string $key): ?int {
    return parsePositiveInt($data[$key] ?? null);
}
function cleanFloat(?array $data, string $key): ?float {
    return parseFloat($data[$key] ?? null);
}
function cleanBool(?array $data, string $key): ?bool {
    return parseBool($data[$key] ?? null);
}
function cleanEmail(?array $data, string $key): ?string {
    return parseEmail($data[$key] ?? null);
}
function cleanDate(?array $data, string $key, string $format = 'Y-m-d'): ?string {
    return parseDate($data[$key] ?? null, $format);
}