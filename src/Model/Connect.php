<?php

namespace Model;

use Common\ControllerTrait;
use mysqli;

class Connect
{
    use ControllerTrait;

    private function connect()
    {
        $settings = $this->settings['db'];

        $conn = new mysqli(
            $settings['host'],
            $settings['username'],
            $settings['password'],
            $settings['database']
        );

        if ($conn->connect_error) {
            die('Что-то пошло не так ' . $conn->connect_error);
        }

        return $conn;
    }

    public function query($query)
    {
        if ($this->connect()->errno != 0) {
            die('Что-то пошло не так ' . $this->connect()->errno);
        }

        return $this->connect()->query($query);
    }

    public function getDataSensor(): ?array
    {
        // Получаем из БД объектом все старые данные
        $sensorData = $this->connect()->query('SELECT * FROM `sensor`');

        // Формирование ассоциативного массива из объекта
        if ($sensorData->num_rows > 0) {
            $table = [];
            while ($arrUsers = $sensorData->fetch_assoc()) {
                $table[] = $arrUsers;
            }
        }

        if (empty($table)) {
            return null;
        }

        return $table;
    }

}