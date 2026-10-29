<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { 
    exit("Brak autoryzacji sesyjnej."); 
}

$current_path = $_SESSION['current_dir'] ?? '';
$action = $_GET['action'] ?? '';

if (empty($current_path) || strpos($current_path, $_SESSION['user_dir']) === false) {
    header('Location: index.php');
    exit();
}

if ($action === 'mkdir' && isset($_POST['dirname'])) {
    $dirname = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['dirname']); 
    
    if (!empty($dirname)) {
        $target_mkdir = $current_path . '/' . $dirname;
        if (!file_exists($target_mkdir)) {
            mkdir($target_mkdir, 0777, true);
        }
    }
}

if ($action === 'upload' && isset($_FILES['fileToUpload'])) {
    $target_file = $current_path . "/" . basename($_FILES["fileToUpload"]["name"]);
    
    if ($_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
}

if ($action === 'unlink' && isset($_GET['name'])) {
    $file_to_del = $current_path . '/' . basename($_GET['name']);
    
    if (file_exists($file_to_del) && !is_dir($file_to_del)) {
        unlink($file_to_del);
    }
}

if ($action === 'rmdir' && isset($_GET['name'])) {
    $dir_to_del = $current_path . '/' . basename($_GET['name']);
    
    if (file_exists($dir_to_del) && is_dir($dir_to_del)) {
        $inner_items = array_diff(scandir($dir_to_del), array('.', '..'));
        
        foreach ($inner_items as $item) {
            $inner_path = $dir_to_del . '/' . $item;
            if (!is_dir($inner_path)) {
                unlink($inner_path); 
            }
        }
        rmdir($dir_to_del);
    }
}

header('Location: index.php');
exit();
?>
