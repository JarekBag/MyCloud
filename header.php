<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">☁️ MyCloud</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white small px-3" href="index.php">Mój Dysk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white small px-3 fw-bold" href="goscie.php">Goście portalu</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center navbar-nav ms-auto">
                    <span class="text-white small me-3">👤 Zalogowany: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Gość'); ?></span>
                    <a class="btn btn-outline-light btn-sm fw-bold shadow-sm" href="logout.php">Wyloguj się</a>
                </div>
            </div>
        </div>
    </nav>
</header>
