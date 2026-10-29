<?php
session_start();

$user = htmlentities($_POST['user'] ?? '', ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'] ?? '', ENT_QUOTES, "UTF-8");
$ip = $_SERVER["REMOTE_ADDR"] ?? '0.0.0.0';
$browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Nieznana';
$datetime = date('Y-m-d H:i:s');


$file_path = 'uzytkownicy.txt';
if (!file_exists($file_path)) {
    touch($file_path);
}

$authenticated = false;
$avatar_name = 'default.png';

$handle = fopen($file_path, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;
        
        $parts = explode(':', $line);
        $stored_user = $parts[0] ?? '';
        $stored_pass = $parts[1] ?? '';
        $stored_avatar = $parts[2] ?? 'default.png';
        
        if ($stored_user === $user && $stored_pass === $pass) {
            $authenticated = true;
            $avatar_name = $stored_avatar;
            break;
        }
    }
    fclose($handle);
}

$log_path = 'rejestr_gosci.txt';

if ($authenticated) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user;
    $_SESSION['avatar'] = $avatar_name;
    
    
    $log_handle = fopen($log_path, 'a');
    if ($log_handle) {
        fwrite($log_handle, $user . '|' . $ip . '|' . $datetime . '|' . $browser . '|SUCCESS' . PHP_EOL);
        fclose($log_handle);
    }
    
    
    $user_dir = "files_" . $user;
    if (!file_exists($user_dir)) {
        mkdir($user_dir, 0755, true); 
    }
    $_SESSION['user_dir'] = $user_dir;     
    $_SESSION['current_dir'] = $user_dir;  
    
    header('Location: index.php');
    exit();
} else {
    // REJESTRACJA BŁĘDNEGO LOGOWANIA
    if (!empty($user)) {
        $log_handle = fopen($log_path, 'a');
        if ($log_handle) {
            fwrite($log_handle, $user . '|' . $ip . '|' . $datetime . '|' . $browser . '|FAILED' . PHP_EOL);
            fclose($log_handle);
        }
    }
    echo "<script>alert('Błędny login lub hasło!'); window.location.href='index.php';</script>";
    exit();
}
?>
