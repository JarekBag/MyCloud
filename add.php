<?php
declare(strict_types=1);
session_start();

$user = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['user'] ?? '');
$pass1 = $_POST['pass1'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

if (empty($user) || empty($pass1)) {
    die("<script>alert('Błąd: Pola nie mogą być puste!'); window.location.href='rejestruj.php';</script>");
}

if ($pass1 !== $pass2) {
    die("<script>alert('Błąd: Podane hasła nie są identyczne!'); window.location.href='rejestruj.php';</script>");
}

$file_path = 'uzytkownicy.txt';
if (!file_exists($file_path)) {
    touch($file_path);
}

$user_exists = false;
$handle = fopen($file_path, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;
        list($stored_user, $stored_pass) = explode(':', $line);
        if ($stored_user === $user) {
            $user_exists = true;
            break;
        }
    }
    fclose($handle);
}

if ($user_exists) {
    die("<script>alert('Błąd: Ta nazwa użytkownika jest już zajęta!'); window.location.href='rejestruj.php';</script>");
}

$handle = fopen($file_path, 'a');
if ($handle) {
    fwrite($handle, $user . ':' . $pass1 . PHP_EOL);
    fclose($handle);
}

echo "<script>alert('Konto utworzone pomyślnie! Zaloguj się.'); window.location.href='index.php';</script>";
exit();
?>
