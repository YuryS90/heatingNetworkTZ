<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

class GetController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        $view = $this->twig->render('sendData.twig', [
            'title' => 'Отправка данных',
        ]);

        $this->write($view);

        return $this->response;
    }
}