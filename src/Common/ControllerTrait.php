<?php

namespace Common;

use ErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

trait ControllerTrait
{
    use CommonTrait;

    private Request $request;
    private Response $response;
    private $args;

    /**
     * @throws ErrorException
     */
    public function __invoke(Request $request, Response $response, array $args)
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

    /**
     * @param $data
     * @return int
     */
    public function write($data): int
    {
        return $this->response->getBody()->write($data);
    }

}