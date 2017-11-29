<?php

class DB
{
    private $connect;

    function __construct() {
        if(!$settings = parse_ini_file('settings.ini', TRUE)) throw new Exception('Не найден файл с настройками');
        $this->connect = new PDO($settings['dns'], $settings['username'], $settings['password']);
    }

    public function getTable($name)
    {
        $query = $this->connect->query("SELECT * FROM ${name};");
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMigration($region_id, $courier_id, $departure, $arrival)
    {
        $sql = 'INSERT INTO `migrations` (region_id, courier_id, departure, arrival) VALUES (:region_id, :courier_id, :departure, :arrival)';

        $query = $this->connect->prepare($sql);

        return $query->execute([
            'region_id' => $region_id,
            'courier_id' => $courier_id,
            'departure' => $departure,
            'arrival' => $arrival,
        ]);
    }

    public function checkFreeCourier($courier_id, $departure)
    {
        $sql = "SELECT courier_id FROM migrations
            WHERE arrival < DATE(:departure) AND courier_id = :courier_id
            ORDER BY arrival DESC 
            LIMIT 1";

        $query = $this->connect->prepare($sql);
        $query->bindParam(':departure', $departure);
        $query->bindParam(':courier_id', $courier_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getMigrationsByDate($date)
    {
        $sql = "SELECT couriers.name as courier_name, regions.name as region_name FROM migrations 
            LEFT JOIN couriers ON couriers.id = migrations.courier_id 
            LEFT JOIN regions ON regions.id = migrations.region_id 
            WHERE departure = :departure";

        $query = $this->connect->prepare($sql);
        $query->bindParam(':departure', $date);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
