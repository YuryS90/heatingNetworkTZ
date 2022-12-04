<?php

namespace Controllers\Home;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class HomeController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        $view = Twig::fromRequest($this->request);

        // Метод render() возвращает новый объект ответа PSR-7,
        // телом которого является визуализированный шаблон Twig.
        return $view->render($this->response, 'home.twig', [
            'title' => 'Главная',
        ]);
    }
}