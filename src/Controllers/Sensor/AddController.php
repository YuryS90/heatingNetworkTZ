<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class AddController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        // Сохраняем массив данных, который пришёл из маршрута "Отправить данные"
        $request = $this->getBody();

        // Сохраняем значения данных в v1 и v2, и обрабатываем
        $v1 = $request['sensorOne'] ?? null;
        $v2 = $request['sensorTwo'] ?? null;

        if (empty($v1)) {
            $v1 = 'данные отсутствуют';
        }

        if (empty($v2)) {
            $v2 = 'данные отсутствуют';
        }

        $view = Twig::fromRequest($this->request);

        if ($v1 == 'данные отсутствуют' || $v2 == 'данные отсутствуют') {
            $this->db->insert("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
            return $view->render($this->response, 'info.twig', ['noData' => true]);
        }

        // Получаем МАССИВ или NULL
        $table = $this->db->getData('SELECT * FROM `sensor`');

        // Проверка на NULL.
        // Если таблица пустая, то не делаем расчёты, а просто добавляем
        if (empty($table)) {
            $this->db->insert("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
            return $view->render($this->response, 'info.twig', ['without' => true]);
        }

        // Получаем последний элемент (предыдущий)
        $oldData = end($table);

        // Если у предыдущего значения с "данные отсутствуют", то не рассчитываем %
        if ($oldData['V1'] == "данные отсутствуют" ||
            $oldData['V2'] == "данные отсутствуют") {
            $this->db->insert("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
            return $view->render($this->response, 'info.twig', ['oldNoData' => true]);
        }

        // Преобразование к типу float
        $oldV1 = floatval($oldData['V1']);
        $oldV2 = floatval($oldData['V2']);
        $v1 = floatval($v1);
        $v2 = floatval($v2);

        // Расчёт погрешности
        $inError = round(((($v1 - $oldV1) - ($v2 - $oldV2)) / ($v1 - $oldV1)) * 100, 2);

        // Добавление новых данный в БД
        $this->db->insert("INSERT INTO `sensor` (`V1`, `V2`, `interest`) VALUES ('$v1', '$v2', '$inError')");

        return $view->render($this->response, 'info.twig', ['all' => true]);
    }
}