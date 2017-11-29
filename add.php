<?php 

if (!$_POST) return;

require_once './db.php';

// $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

$db = new DB();

if (empty($_POST['departure']) && DateTime::createFromFormat('YYYY-mm-dd', $_POST['departure']) !== false) {

    echo json_encode([
        'message' => 'Выберите дату отправления',
        'status' => 'error'
    ]);

    exit();
}

if (!empty($_POST['region_id']) && !empty($_POST['departure']) && !empty($_POST['courier_id'])) {
    $checkCourier = $db->checkFreeCourier($_POST['courier_id'], $_POST['departure']);
    
    if ($checkCourier) {
        $result = $db->addMigration($_POST['region_id'], $_POST['courier_id'], $_POST['departure'], $_POST['arrival']);

        if ($result) {
            echo json_encode([
                'message' => 'Запись успешно добавлена!',
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'message' => 'Неудалось добавить запись!',
                'status' => 'error'
            ]);
        }

        exit();
    } else {
        echo json_encode([
            'message' => "Данный курьер находится в пути. Выберите другого",
            'status' => 'error'
        ]);

        exit();
    }
}

