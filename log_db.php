<?php
function getLogDBConnection() {
    $pdo = new PDO('sqlite:log.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Створення таблиці, якщо не існує
    $pdo->exec("CREATE TABLE IF NOT EXISTS logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        query_type TEXT,
        parameters TEXT,
        timestamp TEXT
    )");

    return $pdo;
}
?>
