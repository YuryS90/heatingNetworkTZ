<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use ErrorException;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ShowController
{
    use ControllerTrait;

    const LIMIT = 3;
    const PAGE_NUM = 1;
    const MID_SIZE = 3;

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError|ErrorException
     */
    public function run(): ResponseInterface
    {
        // Получаем страницу, по которой кликнули
        $pageNum = (isset($_GET['page']) && $_GET['page'] > 0) ? intval($_GET['page']) : 1;

        // Всего страниц
        $totalPages = $this->pagination->getPagesCount(self::LIMIT);

        // Если, например ?page=10000, то ?page=1
        if ($totalPages < $pageNum){
            $pageNum = self::PAGE_NUM;
        }

        // Получаем массив данных для n-й страницы
        $data = $this->pagination->getPage($pageNum, self::LIMIT);
        //$this->dd($data);

        // Получаем массив данных из БД или NULL
        //$data = $this->db->getData('SELECT * FROM `sensor`');

        // Объект Twig
        $view = Twig::fromRequest($this->request);

        // Проверка на NULL
        if (empty($data)) {
            return $view->render($this->response, 'info.twig', ['empty' => true]);
        }

        // Объект Psr7\Response
        return $view->render($this->response, 'show.twig', [
            'title' => 'Данные',
            'data' => $data,

            // Всего страниц
            'totalPages' => $totalPages,

            // Текущая страница
            'currentPageNum' => $pageNum,

            // Для работы цикла
            'pageNum' => self::PAGE_NUM,


            'midSize' => self::MID_SIZE,
            'i' => 1,
        ]);

    }
}