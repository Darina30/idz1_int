<?php
include 'log_db.php';
$logDB = getLogDBConnection();
$logs = $logDB->query("SELECT * FROM logs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лог звернень</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #eaf4fb;
            margin: 20px;
        }
        h2 {
            color: #006699;
            text-align: center;
        }
        table {
            margin: auto;
            width: 90%;
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
        caption {
            caption-side: bottom;
            font-size: 0.9em;
            color: #666;
            margin-top: 10px;
        }
        .back {
            text-align: center;
            margin-top: 20px;
        }
        .back a {
            text-decoration: none;
            font-weight: bold;
            color: #006699;
        }
    </style>
</head>
<body>
    <h2>Журнал звернень користувачів</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Тип запиту</th>
            <th>Параметри</th>
            <th>Дата і час</th>
        </tr>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log['id'] ?></td>
                <td><?= htmlspecialchars($log['query_type']) ?></td>
                <td><?= htmlspecialchars($log['parameters']) ?></td>
                <td><?= $log['timestamp'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <caption>Логування виконано за допомогою SQLite + PDO</caption>
    <div class="back"><a href="index.php">← Назад до пошуку</a></div>
</body>
</html>


