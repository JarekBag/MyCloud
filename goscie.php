<?php
declare(strict_types=1);
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { 
    header('Location: index.php'); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title>Bagiński - Historia logowań</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script> 
</head>
<body onload="myLoadHeader()" style="background-color: #ffffe6 !important; padding-top: 80px;">
<div id="myHeader"></div>
<main class="container">
    <section class="sekcja1">
        <div class="p-4 bg-white rounded shadow border border-primary mt-3 mx-auto" style="max-width: 1100px;">
            <h2 class="h4 text-dark mb-4">👥 Historia logowań (Goście portalu)</h2>
            <div class="table-responsive">
                <?php
                $log_path = 'rejestr_gosci.txt';

                print "<table class='table table-striped table-bordered align-middle' style='font-size: 13px;'>";
                print "<tr class='table-primary'>
                        <td class='fw-bold'>Użytkownik</td>
                        <td class='fw-bold'>Adres IP</td>
                        <td class='fw-bold'>Data i godzina</td>
                        <td class='fw-bold'>Przeglądarka / System</td>
                        <td class='fw-bold'>Stan</td>
                      </tr>\n";

                if (file_exists($log_path)) {
                    $lines = file($log_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    $lines = array_reverse($lines); // Najnowsze logowania na samej górze

                    foreach ($lines as $line) {
                        $data = explode('|', $line);
                        if (count($data) < 5) continue;

                        $user_log    = htmlspecialchars($data[0]);
                        $ip_log      = htmlspecialchars($data[1]); 
                        $time_log    = htmlspecialchars($data[2]);
                        $browser_log = htmlspecialchars($data[3]);
                        $status_log  = $data[4];

                        $stan = ($status_log === 'SUCCESS') ? "<span class='text-success small fw-bold'>OK</span>" : "<span class='text-danger small fw-bold'>BŁĄD</span>";

                        print "<tr>";
                        print "<td><b>$user_log</b></td>";
                        print "<td class='text-danger'>$ip_log</td>";
                        print "<td>$time_log</td>";
                        print "<td class='text-muted small'>$browser_log</td>";
                        print "<td>$stan</td>";
                        print "</tr>";
                    }
                }
                print "</table>";
                ?>
            </div>
            <p class="mt-3 text-center mb-0"><a href="index.php" class="text-decoration-none small fw-bold">← Wróć do Dysku Plików</a></p>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
