<?php 
declare(strict_types=1);
session_start();

$user = htmlentities($_POST['user'] ?? '', ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'] ?? '', ENT_QUOTES, "UTF-8");

$file_path = 'uzytkownicy.txt';
if (!file_exists($file_path)) {
    touch($file_path);
}

$authenticated = false;

$handle = fopen($file_path, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;
        
        list($stored_user, $stored_pass) = explode(':', $line);
        
        if ($stored_user === $user && $stored_pass === $pass) {
            $authenticated = true;
            break;
        }
    }
    fclose($handle);
}

if ($authenticated) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user;
    
    $user_dir = "files_" . $user;
    if (!file_exists($user_dir)) {
        mkdir($user_dir, 0755, true); 
    }
    
    $_SESSION['user_dir'] = $user_dir;     
    $_SESSION['current_dir'] = $user_dir;  

    header('Location: index.php');
    exit();
} else {
    echo "<script>alert('Błędny login lub hasło!'); window.location.href='index.php';</script>";
    exit();
}
?>
