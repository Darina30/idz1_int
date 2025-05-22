<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Товари в магазині</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Пошук товарів</h2>

    <form action="fetch.php" method="GET">
        <label>Виберіть виробника:</label>
        <select name="vendor">
            <?php
            $vendors = $pdo->query("SELECT * FROM vendors")->fetchAll();
            foreach ($vendors as $vendor) {
                echo "<option value='{$vendor['ID_Vendors']}'>{$vendor['v_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="filter" value="vendor">Пошук</button>
    </form>

    <form action="fetch.php" method="GET">
        <label>Виберіть категорію:</label>
        <select name="category">
            <?php
            $categories = $pdo->query("SELECT * FROM category")->fetchAll();
            foreach ($categories as $category) {
                echo "<option value='{$category['ID_Category']}'>{$category['c_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="filter" value="category">Пошук</button>
    </form>

    <form action="fetch.php" method="GET">
        <label>Ціновий діапазон:</label>
        <input type="number" name="min_price" placeholder="Від" required>
        <input type="number" name="max_price" placeholder="До" required>
        <button type="submit" name="filter" value="price">Пошук</button>
    </form>
</body>
</html>