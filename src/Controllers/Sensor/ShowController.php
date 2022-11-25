<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

class ShowController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        // Получаем массив данных из БД
        $table = $this->db->getDataSensor();

        $view = $this->twig->render('show.twig', [
            'title' => 'Показать данные',
            'table' => $table,
        ]);

        $this->write($view);

        return $this->response;
    }
}