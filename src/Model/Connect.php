<?php

namespace Model;

use mysqli;
use mysqli_result;

class Connect
{
    private $connection;
    const TABLE = 'sensor';


    /**
     * @param $settings
     */
    public function __construct($settings)
    {
        $this->connection = $this->connect($settings);
    }

    /**
     * @param $settings
     * @return mysqli|void
     */
    private function connect($settings)
    {
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

    /**
     * @param $query
     * @return bool|mysqli_result|void
     */
    public function insert($query)
    {
        if ($this->connection->errno != 0) {
            die('Что-то пошло не так ' . $this->connection->errno);
        }

        return $this->connection->query($query);
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }

    /**
     * @param $query
     * @return array|null
     */
    public function getData($query): ?array
    {
        $mysqliResult = $this->connection->query($query);

        if ($mysqliResult->num_rows == 0) {
            return null;
        }

        $data = [];
        while ($item = $mysqliResult->fetch_assoc()) {
            $data[] = $item;
        }

        return $data;
    }

}