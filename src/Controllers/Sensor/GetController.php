<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class GetController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'sendData.twig', [
            'title' => 'Отправка данных',
        ]);
    }
}