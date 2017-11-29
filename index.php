<?php
require_once './db.php';

$db = new DB();

$migrations = $db->getMigrationsByDate(date('Y-m-d'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Рассписание</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style>
        body{
            padding-top: 40px;
        }

        #info_table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/form.php" class="btn btn-primary">Добавить</a>
        <table id="info_table" class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Курьер</th>
                    <th>Регион</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($migrations as $migration): ?>
                    <tr>
                        <td><?= $migration['courier_name'] ?></td>
                        <td><?= $migration['region_name'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>