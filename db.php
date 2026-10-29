<?php
$db_host = 'localhost'; 
$db_user = 'srv125880_PAS'; 
$db_pass = 'MdgizqDBxkO8'; 
$db_name = 'srv125880_Z5'; 

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(!$link) { 
    die("Błąd połączenia z bazą: " . mysqli_connect_error()); 
}
mysqli_query($link, "SET NAMES 'utf8'");


mysqli_query($link, "CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(128) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `avatar` VARCHAR(255) DEFAULT 'none',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");


mysqli_query($link, "CREATE TABLE IF NOT EXISTS `goscieportalu` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(128) NOT NULL,
  `ipaddress` VARCHAR(45) NOT NULL,
  `browser` VARCHAR(255) NOT NULL,
  `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('SUCCESS', 'FAILED') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
?>
