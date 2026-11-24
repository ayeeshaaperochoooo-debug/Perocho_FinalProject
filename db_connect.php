<?php
$host = "sql108.infinityfree.com";
$dbname = "if0_43524489_electronic_store";
$username = "if0_43524489";
$password = "CZ3b9pfpac";


try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
