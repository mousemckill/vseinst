<?php 
require_once './db.php';

$db = new DB();

$regions = $db->getTable('regions');
$couriers = $db->getTable('couriers');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style>
        body{
            padding-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/index.php" class="btn btn-secondary">< На главную</a>
        <form action="add.php" method="POST" id="addForm">
            <div class="form-group">
                <label for="regionInput">Регионы</label>
                <select name="region_id" id="regionInput" class="form-control">
                    <?php foreach($regions as $region): ?>
                        <option value="<?= $region['id'] ?>" data-durability="<?= $region['durability'] ?>"><?= $region['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departureInput">Дата выезда</label>
                <input type="date" class="form-control" id="departureInput" name="departure">
            </div>
            <div class="form-group">
                <label for="courierInput">Курьер</label>
                <select name="courier_id" id="courierInput" class="form-control">
                    <?php foreach($couriers as $courier): ?>
                        <option value="<?= $courier['id'] ?>"><?= $courier['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="arrivalInput">Дата прибытия</label>
                <input type="date" readonly class="form-control" id="arrivalInput" name="arrival">
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

    <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>

    <script>
        ;(function(){
            function submit(form) {
                var formData = $(form).serialize();
                $.ajax({
                    url: '/add.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'error') {
                            alert(data.message);
                        } else {
                            alert(data.message);
                            $(form)[0].reset();
                        }
                    }
                })
            }
            
            $('#addForm').on('submit', function(e){
                e.preventDefault();
                submit(e.target);
            });

            function calcArrival(){
                var durability = $('#regionInput option:selected').data('durability');
                var departure = $('#departureInput').val();

                if (departure.length > 0) {
                    var arrivalDate = new Date(departure);
                    arrivalDate.setDate(arrivalDate.getDate() + durability);

                    $('#arrivalInput').val(arrivalDate.toISOString().slice(0,10));
                } else {
                    $('#arrivalInput').val('');
                }
            }

            $('#regionInput').on('change', calcArrival);
            $('#departureInput').on('change', calcArrival);
        })();
    </script>
</body>
</html>