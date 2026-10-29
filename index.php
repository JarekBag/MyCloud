<?php 
declare(strict_types=1); 
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'levelup') {
    $_SESSION['current_dir'] = $_SESSION['user_dir'];
    header('Location: index.php');
    exit();
}

if (isset($_GET['cd']) && !empty($_GET['cd'])) {
    $_SESSION['current_dir'] = $_SESSION['user_dir'] . '/' . basename($_GET['cd']);
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title>Bagiński - MyCloud</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script> 
</head>

<?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #ffffe6 !important;">
<main class="w-100" style="max-width: 330px; padding: 15px;">
    <form method="POST" action="weryfikuj_z4.php" class="text-center bg-white p-4 rounded shadow border">
        <h1 class="h3 mb-3 fw-normal">Zaloguj się (MyCloud)</h1>
        <div class="form-floating mb-2">
            <input type="text" name="user" class="form-control" id="floatingInput" placeholder="Login" required>
            <label for="floatingInput">Login</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Hasło" required>
            <label for="floatingPassword">Hasło</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj</button>
        <p class="mt-3 mb-0"><a href="rejestruj.php">Nie masz konta? Zarejestruj się</a></p>
    </form>
</main>
</body>

<?php else: ?>
<!-- DOKŁADNA STRUKTURA ŁADOWANIA INTERFEJSU Z TWOJEGO ZADANIA 2 -->
<body onload="myLoadHeader()" style="background-color: #ffffe6;">
<div id="myHeader"></div>

<main class="container"> 
    <section class="sekcja1 p-4 bg-white rounded shadow border border-primary my-4" style="margin-top: 60px !important;">
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h2 class="h5 mb-0 fw-bold">Twoje pliki w chmurze</h2>
                <p class="text-muted small mb-0">Zarządzaj plikami i strukturą katalogów sesyjnych</p>
            </div>
            
            <div class="d-flex gap-2">
                <?php 
                $current_path = $_SESSION['current_dir'] ?? $_SESSION['user_dir'];
                $is_sub_dir = ($current_path !== $_SESSION['user_dir']);
                if (!$is_sub_dir): 
                ?>
                    <button class="btn btn-outline-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#mkdirModal">➕ Nowy podkatalog</button>
                <?php else: ?>
                    <a href="index.php?action=levelup" class="btn btn-outline-secondary btn-sm fw-bold">↩️ Wróć (Level Up)</a>
                <?php endif; ?>
                <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModal">📤 Prześlij plik</button>
            </div>
        </div>

        <p class="text-muted small font-monospace">Ścieżka: <?php echo htmlspecialchars($current_path); ?></p>

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nazwa elementu</th>
                        <th>Typ</th>
                        <th class="text-center">Podgląd HTML5</th>
                        <th class="text-end">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (file_exists($current_path)) {
                    $files = array_diff(scandir($current_path), array('.', '..'));
                } else {
                    $files = [];
                }

                if (empty($files)) {
                    echo "<tr><td colspan='4' class='text-center text-muted py-3'>Ten folder jest pusty.</td></tr>";
                }
                
                foreach ($files as $file) {
                    $full_file_path = $current_path . '/' . $file;
                    $is_dir = is_dir($full_file_path);
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                    echo "<tr>";
                    if ($is_dir) {
                        echo "<td>📂 <a href='index.php?cd=" . urlencode($file) . "' class='fw-bold text-decoration-none'>" . htmlspecialchars($file) . "</a></td>";
                        echo "<td><span class='badge bg-info text-dark'>Podkatalog</span></td>";
                        echo "<td></td>";
                        echo "<td class='text-end'><a href='operacje.php?action=rmdir&name=" . urlencode($file) . "' class='btn btn-sm btn-outline-danger py-0 px-2' onclick='return confirm(\"Czy usunąć katalog z plikami?\")'>❌ Usunąć</a></td>";
                    } else {
                        echo "<td>📄 <a href='$full_file_path' download class='text-dark'>" . htmlspecialchars($file) . "</a></td>";
                        echo "<td><span class='badge bg-secondary'>Plik (." . $ext . ")</span></td>";
                        
                        echo "<td class='text-center'>";
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<a href='$full_file_path' target='_blank'><img src='$full_file_path' class='img-thumbnail shadow-sm' style='max-height: 50px; object-fit: cover;'></a>";
                        } elseif ($ext === 'mp3') {
                            echo "<audio controls preload='none' class='w-100' style='height: 30px;'><source src='$full_file_path' type='audio/mpeg'></audio>";
                        } elseif ($ext === 'mp4') {
                            echo "<video controls preload='none' class='rounded border shadow-sm' style='max-height: 60px; max-width: 150px;'><source src='$full_file_path' type='video/mp4'></video>";
                        } else {
                            echo "<span class='text-muted small'>Brak podglądu</span>";
                        }
                        echo "</td>";
                        
                        echo "<td class='text-end'><a href='operacje.php?action=unlink&name=" . urlencode($file) . "' class='btn btn-sm btn-outline-danger py-0 px-2' onclick='return confirm(\"Czy usunąć ten plik?\")'>❌ Usunąć</a></td>";
                    }
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<div class="modal fade" id="mkdirModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="operacje.php?action=mkdir" method="POST" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">📁 Nowy folder</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><input type="text" name="dirname" class="form-control" pattern="[a-zA-Z0-9]+" placeholder="Tylko litery i cyfry" required></div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary btn-sm">Utwórz katalog</button></div>
        </form>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="operacje.php?action=upload" method="POST" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">📤 Prześlij plik</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><input type="file" name="fileToUpload" class="form-control" required></div>
            <div class="modal-footer"><button type="submit" name="submit" class="btn btn-primary btn-sm">Rozpocznij przesyłanie</button></div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
<?php endif; ?>
</html>
