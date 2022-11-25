<?php

namespace Controllers\Home;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        $view = $this->twig->render('home.twig', [
            'title' => 'Главная',
        ]);

        $this->write($view);

        return $this->response;
    }
}