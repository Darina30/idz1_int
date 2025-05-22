<?php
include 'db.php';
include 'log_db.php';

$logDB = getLogDBConnection();
$products = [];
$title = "Результати пошуку";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #eaf4fb;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #006699;
        }
        table {
            margin: auto;
            width: 85%;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #d0e5f5;
        }
        th {
            background: #006699;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f0f8ff;
        }
        .back {
            display: block;
            text-align: center;
            margin: 20px 0;
        }
        .back a {
            text-decoration: none;
            color: #006699;
            font-weight: bold;
        }
        .message {
            text-align: center;
            color: #444;
            font-size: 1.1em;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    $paramsString = '';
    $timestamp = date("Y-m-d H:i:s");

    if ($filter === "vendor" && isset($_GET['vendor'])) {
        $paramsString = "vendor_id=" . $_GET['vendor'];
        $stmt = $pdo->prepare("SELECT items.name, items.price FROM items WHERE FID_Vendor = :vendorId");
        $stmt->execute(['vendorId' => $_GET['vendor']]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>Товари обраного виробника</h2>";
    } elseif ($filter === "category" && isset($_GET['category'])) {
        $paramsString = "category_id=" . $_GET['category'];
        $stmt = $pdo->prepare("SELECT items.name, items.price FROM items WHERE FID_Category = :categoryId");
        $stmt->execute(['categoryId' => $_GET['category']]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>Товари в обраній категорії</h2>";
    } elseif ($filter === "price" && isset($_GET['min_price'], $_GET['max_price'])) {
        $paramsString = "min=" . $_GET['min_price'] . ", max=" . $_GET['max_price'];
        $stmt = $pdo->prepare("SELECT name, price FROM items WHERE price BETWEEN :minPrice AND :maxPrice");
        $stmt->execute([
            'minPrice' => $_GET['min_price'],
            'maxPrice' => $_GET['max_price']
        ]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>Товари у вибраному ціновому діапазоні</h2>";
    }

    // Логування
    $logStmt = $logDB->prepare("INSERT INTO logs (query_type, parameters, timestamp) VALUES (:type, :params, :time)");
    $logStmt->execute([
        'type' => $filter,
        'params' => $paramsString,
        'time' => $timestamp
    ]);

    if (!empty($products)) {
        echo "<table><tr><th>Назва товару</th><th>Ціна</th></tr>";
        foreach ($products as $product) {
            echo "<tr><td>{$product['name']}</td><td>{$product['price']} грн</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='message'>Немає товарів за заданими критеріями.</p>";
    }
}
?>
<div class="back"><a href="index.php">← Назад до пошуку</a></div>
</body>
</html>
