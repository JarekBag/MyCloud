<?php
declare(strict_types=1);
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title>Bagiński - Rejestracja MyCloud</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #ffffe6;">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">☁️ MyCloud</a>
    </div>
</nav>

<main class="container" style="margin-top: 80px;">
    <section class="sekcja1">
        <div class="p-4 bg-white rounded shadow mx-auto" style="max-width: 500px;">
            <form method="POST" action="add.php">
                <h2 class="text-center mb-4 fw-bold text-primary">Rejestracja MyCloud</h2>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nazwa użytkownika:</label>
                    <input type="text" name="user" class="form-control" placeholder="Wpisz login" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Hasło:</label>
                    <input type="password" name="pass1" class="form-control" placeholder="Wpisz hasło" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Powtórz hasło:</label>
                    <input type="password" name="pass2" class="form-control" placeholder="Powtórz hasło" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Zarejestruj się</button>
                <p class="mt-3 text-center mb-0"><a href="index.php" class="text-decoration-none fw-semibold">Masz już konto? Zaloguj się</a></p>
            </form>
        </div>
    </section>
</main>
</body>
</html>
