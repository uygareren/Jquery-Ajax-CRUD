<?php
$host = 'localhost'; 
$dbname = 'ajax-todo'; 
$username = 'root'; 
$password = ''; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    echo "Veritabanına bağlantı başarılı!";
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

