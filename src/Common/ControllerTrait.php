<?php

namespace Common;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

trait ControllerTrait
{
    use CommonTrait;

    private Request $request;
    private Response $response;
    private $args;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        //Вызываю метод run() из контроллера
        return $this->run();
    }

    /**
     * @return array|object|null
     */
    public function getBody()
    {
        return $this->request->getParsedBody();
    }
}